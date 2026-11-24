<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class ToolsBackupController extends Controller
{
    protected BackupService $backup;

    public function __construct(BackupService $backup)
    {
        $this->backup = $backup;
    }

    public function index()
    {
        $localBackups = $this->backup->getBackups('local');
        $downloadBackups = $this->backup->getBackups('download');

        $settings = [
            'mode' => rj_get_option('backup_mode', 'manual'),
            'schedule' => rj_get_option('backup_schedule', 'daily'),
            'local_limit' => (int) rj_get_option('backup_local_limit', 5),
            'download_limit' => (int) rj_get_option('backup_download_limit', 2),
            'include_db' => rj_get_option('backup_include_db', '1') === '1',
            'include_files' => rj_get_option('backup_include_files', '1') === '1',
        ];

        return view('admin.tools.backup', compact('localBackups', 'downloadBackups', 'settings'));
    }

    public function create(Request $request)
    {
        @set_time_limit(0);

        $validated = $request->validate([
            'type' => 'required|in:full,database,files',
        ]);

        $storage = rj_get_option('backup_storage_mode', 'local');

        $result = match ($validated['type']) {
            'full' => $this->backup->createFullBackup($storage),
            'database' => $this->backup->createDatabaseBackup($storage),
            'files' => $this->backup->createFilesBackup($storage),
        };

        if ($request->expectsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    // YENİ: Gedişatı yoxlayan metod
    public function progress()
    {
        $progress = Cache::get('backup_progress', [
            'status' => 'idle',
            'percent' => 0,
            'label' => __('Waiting for backup...'),
        ]);

        return response()->json($progress);
    }

    public function download(Request $request, string $filename)
    {
        $type = $request->input('type', 'download');
        $path = storage_path('app/backups/' . $type . '/' . basename($filename));

        if (!File::exists($path)) {
            return back()->with('error', __('Backup file not found.'));
        }

        return response()->download($path);
    }

    public function delete(Request $request, string $filename)
    {
        $validated = $request->validate([
            'type' => 'required|in:local,download',
        ]);

        $result = $this->backup->delete($filename, $validated['type']);

        if ($request->expectsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function restore(Request $request, string $filename)
    {
        @set_time_limit(0);

        $type = $request->input('type', 'local');
        $result = $this->backup->restore($filename, $type);

        if ($request->expectsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|in:manual,auto',
            'schedule' => 'required|in:daily,weekly,monthly',
            'local_limit' => 'required|integer|min:1|max:20',
            'download_limit' => 'required|integer|min:1|max:3',
            'include_db' => 'nullable|boolean',
            'include_files' => 'nullable|boolean',
        ]);

        rj_set_option('backup_mode', $validated['mode']);
        rj_set_option('backup_schedule', $validated['schedule']);
        rj_set_option('backup_local_limit', (string) $validated['local_limit']);
        rj_set_option('backup_download_limit', (string) $validated['download_limit']);
        rj_set_option('backup_include_db', $request->boolean('include_db') ? '1' : '0');
        rj_set_option('backup_include_files', $request->boolean('include_files') ? '1' : '0');

        rj_flush_options();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Settings saved.'),
            ]);
        }

        return back()->with('success', __('Settings saved.'));
    }
}