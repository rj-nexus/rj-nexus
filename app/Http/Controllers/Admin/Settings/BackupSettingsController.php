<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Option;
use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupSettingsController extends BaseSettingsController
{
    protected string $backupPath;
    protected BackupService $backup;

    public function __construct(BackupService $backup)
    {
        $this->backup = $backup;
        $this->backupPath = storage_path('app/backups');

        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }

    public function index()
    {
        $options = $this->getGroup('backup');

        $data = [
            'schedules' => $this->schedules(),
            'backups' => $this->listBackups(),
            'stats' => $this->stats(),
        ];

        return view('admin.settings.backup', compact('options', 'data'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'backup_storage_mode' => ['required', 'in:local,download'],
            'backup_schedule' => ['required', 'in:never,daily,weekly,monthly'],
            'backup_retention' => ['nullable', 'integer', 'min:1', 'max:100'],
            'backup_include_db' => ['nullable', 'boolean'],
            'backup_include_files' => ['nullable', 'boolean'],
        ]);

        $data['backup_include_db'] = $request->boolean('backup_include_db') ? '1' : '0';
        $data['backup_include_files'] = $request->boolean('backup_include_files') ? '1' : '0';

        if ($data['backup_storage_mode'] === 'download') {
            $data['backup_schedule'] = 'never';
        }

        foreach ($data as $name => $value) {
            Option::set($name, $value, 'backup');
        }

        rj_flush_options();

        return back()->with('success', __('Backup settings saved.'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:site,database,full'],
        ]);

        @set_time_limit(0);
        @ignore_user_abort(true);

        $userId = (int) auth()->id();
        $storageMode = rj_get_option('backup_storage_mode', 'local');
        $targetDir = $storageMode === 'download' ? 'download' : 'local';

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        $this->backup->deleteStaleProgress($userId);
        $this->backup->setProgress($userId, 'init', __('Starting backup...'), 1, 'running');

        $result = match ($validated['type']) {
            'database' => $this->backup->createDatabaseBackup($targetDir, $userId),
            'site' => $this->backup->createFilesBackup($targetDir, $userId),
            'full' => $this->backup->createFullBackup($targetDir, $userId),
        };

        if ($request->expectsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        if ($storageMode === 'download' && File::exists($result['path'] ?? '')) {
            return response()->download($result['path'], $result['filename'])->deleteFileAfterSend(true);
        }

        return back()->with('success', __('Backup created: :file', ['file' => $result['filename']]));
    }

    public function progress()
    {
        $userId = (int) auth()->id();
        return response()->json($this->backup->progress($userId));
    }

    public function download(string $file)
    {
        $file = basename($file);

        foreach (['local', 'download'] as $type) {
            $path = $this->backupPath . '/' . $type . '/' . $file;

            if (File::exists($path)) {
                return response()->download($path);
            }
        }

        return back()->with('error', __('Backup file not found.'));
    }

    public function delete(string $file)
    {
        $file = basename($file);
        $deleted = false;

        foreach (['local', 'download'] as $type) {
            $path = $this->backupPath . '/' . $type . '/' . $file;

            if (File::exists($path)) {
                @unlink($path);
                $deleted = true;
            }
        }

        if (!$deleted) {
            return back()->with('error', __('Backup file not found.'));
        }

        return back()->with('success', __('Backup deleted.'));
    }

    public function restore(Request $request, string $file)
    {
        $validated = $request->validate([
            'type' => ['nullable', 'in:local,download'],
        ]);

        @set_time_limit(0);
        @ignore_user_abort(true);

        $userId = (int) auth()->id();
        $filename = basename($file);
        $type = $validated['type'] ?? 'local';

        $path = $this->backupPath . '/' . $type . '/' . $filename;
        if (!File::exists($path)) {
            $path = $this->backupPath . '/download/' . $filename;
            if (!File::exists($path)) {
                $path = $this->backupPath . '/local/' . $filename;
            }
        }

        if (!File::exists($path)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => __('Backup file not found.')], 404);
            }
            return back()->with('error', __('Backup file not found.'));
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        $this->backup->deleteStaleProgress($userId);
        $this->backup->setProgress($userId, 'init', __('Starting restore...'), 1, 'running');

        $result = $this->backup->restore($filename, $type, $userId);

        if ($request->expectsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    protected function listBackups(): array
    {
        $result = [];

        foreach (['local', 'download'] as $type) {
            $dir = $this->backupPath . '/' . $type;

            if (!File::isDirectory($dir)) {
                continue;
            }

            foreach (File::files($dir) as $file) {
                $ext = strtolower($file->getExtension());
                if (!in_array($ext, ['zip', 'sql'], true)) continue;

                $result[] = [
                    'name' => $file->getFilename(),
                    'size' => $this->humanSize($file->getSize()),
                    'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                    'age' => $this->humanAge($file->getMTime()),
                    'storage' => $type,
                    'extension' => $ext,
                ];
            }
        }

        usort($result, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));

        return $result;
    }

    protected function stats(): array
    {
        $totalSize = 0;
        $count = 0;

        foreach (['local', 'download'] as $type) {
            $dir = $this->backupPath . '/' . $type;
            if (!File::isDirectory($dir)) continue;

            foreach (File::files($dir) as $file) {
                $totalSize += $file->getSize();
                $count++;
            }
        }

        return [
            'count' => $count,
            'total_size' => $this->humanSize($totalSize),
            'disk_free' => $this->humanSize(@disk_free_space(storage_path()) ?: 0),
            'disk_total' => $this->humanSize(@disk_total_space(storage_path()) ?: 0),
        ];
    }

    protected function humanSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    protected function humanAge(int $timestamp): string
    {
        $diff = time() - $timestamp;

        if ($diff < 60) return $diff . 's ' . __('ago');
        if ($diff < 3600) return floor($diff / 60) . 'm ' . __('ago');
        if ($diff < 86400) return floor($diff / 3600) . 'h ' . __('ago');
        if ($diff < 2592000) return floor($diff / 86400) . 'd ' . __('ago');

        return floor($diff / 2592000) . 'mo ' . __('ago');
    }

    protected function schedules(): array
    {
        return [
            'never' => __('Never') . ' — ' . __('Manual backups only'),
            'daily' => __('Daily') . ' — ' . __('Every day at 3:00 AM'),
            'weekly' => __('Weekly') . ' — ' . __('Every Sunday at 3:00 AM'),
            'monthly' => __('Monthly') . ' — ' . __('1st day of month at 3:00 AM'),
        ];
    }
}