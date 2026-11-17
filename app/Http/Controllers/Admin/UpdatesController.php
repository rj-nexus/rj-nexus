<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Option;
use App\Services\BackupService;
use App\Services\GitHubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdatesController extends Controller
{
    protected string $repo;
    protected string $currentVersion;

    public function __construct()
    {
        $this->repo = rj_get_option('update_repo', 'rj-nexus/rj-nexus');

        $configVersion = ltrim((string) config('app.version', '1.9.6'), 'v');
        $dbVersion = ltrim((string) rj_get_option('rj_version', '1.0.0'), 'v');

        $this->currentVersion = $configVersion;

        if (version_compare($configVersion, $dbVersion, '>')) {
            rj_set_option('rj_version', $configVersion);
        }
    }

    public function index()
    {
        $options = Option::where('option_group', 'updates')
            ->pluck('option_value', 'option_name')
            ->toArray();

        $data = [
            'currentVersion' => $this->currentVersion,
            'lastChecked' => $options['last_checked'] ?? null,
            'lastRelease' => $this->getCachedRelease(),
        ];

        return view('admin.updates.index', compact('options', 'data'));
    }

    public function check(GitHubService $github)
    {
        try {
            $repoParts = explode('/', $this->repo);
            if (count($repoParts) !== 2) {
                return back()->with('error', __('Invalid repository format.'));
            }

            $releases = $github->getReleases($repoParts[0], $repoParts[1]);
            $release = $this->pickLatestRelease($releases);

            if (!$release) {
                return back()->with('error', __('No releases found.'));
            }

            $latest = ltrim($release['tag_name'], 'v');
            $hasUpdate = version_compare($latest, $this->currentVersion, '>');

            $downloadUrl = $this->pickDownloadUrl($release);

            Option::set('last_checked', now()->toDateTimeString(), 'updates');
            Option::set('last_release', json_encode([
                'version' => $latest,
                'name' => $release['name'] ?? $release['tag_name'],
                'body' => $release['body'] ?? '',
                'url' => $release['html_url'] ?? '',
                'download_url' => $downloadUrl,
                'published_at' => $release['published_at'] ?? null,
                'prerelease' => (bool) ($release['prerelease'] ?? false),
                'has_update' => $hasUpdate,
            ]), 'updates');

            return back();
        } catch (\Throwable $e) {
            return back()->with('error', __('Update check failed: :message', ['message' => $e->getMessage()]));
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'update_repo' => ['required', 'string', 'max:255', 'regex:/^[\w\-\.]+\/[\w\-\.]+$/'],
            'auto_check' => ['nullable', 'boolean'],
        ]);

        $data['auto_check'] = $request->boolean('auto_check') ? '1' : '0';

        foreach ($data as $name => $value) {
            Option::set($name, $value, 'updates');
        }

        Cache::forget('github_releases_' . str_replace('/', '_', $this->repo));

        return back()->with('success', __('Update settings saved.'));
    }

    public function progress(Request $request)
    {
        $userId = (int) $request->user()->id;
        $data = Cache::get('rj_update_progress_' . $userId, [
            'step' => 'idle',
            'label' => '',
            'percent' => 0,
            'status' => 'idle',
            'message' => '',
        ]);

        return response()->json($data);
    }

    public function run(BackupService $backup, Request $request)
    {
        $userId = (int) auth()->id();
        $wantsJson = $request->expectsJson() || $request->ajax();

        $release = $this->getCachedRelease();

        if (empty($release) || empty($release['has_update'])) {
            $msg = __('No update available to install.');
            return $wantsJson ? response()->json(['success' => false, 'message' => $msg], 422) : back()->with('error', $msg);
        }

        if (empty($release['download_url'])) {
            $msg = __('Download URL missing. Please run "Check for Updates" again.');
            return $wantsJson ? response()->json(['success' => false, 'message' => $msg], 422) : back()->with('error', $msg);
        }

        $lock = Cache::lock('rj_update_in_progress', 900);
        if (!$lock->get()) {
            $msg = __('An update is already in progress. Please wait.');
            return $wantsJson ? response()->json(['success' => false, 'message' => $msg], 423) : back()->with('error', $msg);
        }

        @set_time_limit(900);
        @ini_set('memory_limit', '512M');

        $timestamp = now()->format('YmdHis');
        $zipPath = storage_path('app/temp/update-' . $timestamp . '.zip');
        $extractPath = storage_path('app/temp/update-' . $timestamp);
        $codeBackupPath = storage_path('app/temp/pre-update-' . $timestamp . '.zip');

        $composerBefore = File::exists(base_path('composer.json')) ? md5_file(base_path('composer.json')) : '';

        $protected = [
            '.env', '.env.backup', '.env.example',
            'storage', 'vendor', 'node_modules',
            '.git', '.github', '.gitignore',
            'public/uploads', 'public/storage',
            'rj-content/themes', 'rj-content/plugins',
            'installer',
            'database/seeders/data',
        ];

        $dbBackupFilename = null;
        $dbRestored = false;

        $this->setProgress($userId, 'init', __('Preparing update...'), 5, 'running');

        try {
            $this->setProgress($userId, 'backup', __('Creating database and code backup...'), 10, 'running');

            $backupResult = $backup->create('local');
            if (empty($backupResult['success'])) {
                throw new \RuntimeException(__('Backup failed: :msg', ['msg' => $backupResult['message'] ?? '']));
            }
            $dbBackupFilename = $backupResult['filename'] ?? null;

            File::ensureDirectoryExists(dirname($zipPath));
            File::ensureDirectoryExists($extractPath);

            $this->setProgress($userId, 'download', __('Downloading update package from GitHub...'), 25, 'running');

            $response = Http::withHeaders([
                'User-Agent' => 'RJ-Nexus-Updater/1.0',
                'Accept' => 'application/octet-stream, application/zip, */*',
            ])
                ->timeout(600)
                ->withOptions(['allow_redirects' => ['max' => 10, 'strict' => false, 'referer' => false, 'protocols' => ['http', 'https']]])
                ->sink($zipPath)
                ->get($release['download_url']);

            if (!$response->successful()) {
                throw new \RuntimeException(__('Download failed with HTTP :code', ['code' => $response->status()]));
            }

            if (!File::exists($zipPath) || File::size($zipPath) < 1024) {
                throw new \RuntimeException(__('Downloaded file is empty or too small.'));
            }

            $this->setProgress($userId, 'extract', __('Extracting archive...'), 45, 'running');

            $zip = new \ZipArchive();
            if ($zip->open($zipPath) !== true) {
                throw new \RuntimeException(__('Cannot open downloaded ZIP file.'));
            }
            $zip->extractTo($extractPath);
            $zip->close();

            $entries = array_values(array_filter(File::directories($extractPath)));
            $root = count($entries) === 1 ? $entries[0] : $extractPath;

            $this->setProgress($userId, 'verify', __('Verifying built assets...'), 55, 'running');

            $manifestPath = $root . '/public/build/manifest.json';
            if (!File::exists($manifestPath)) {
                throw new \RuntimeException(__('Update aborted: the release package is missing public/build/manifest.json. The developer must include built assets in the release.'));
            }

            $manifestData = json_decode(File::get($manifestPath), true);
            if (!is_array($manifestData) || empty($manifestData)) {
                throw new \RuntimeException(__('Update aborted: public/build/manifest.json is invalid.'));
            }

            $this->setProgress($userId, 'backup_code', __('Creating code snapshot for rollback...'), 62, 'running');

            Artisan::call('down', ['--render' => 'errors::503']);

            $this->createCodeBackup($codeBackupPath, $protected);

            $this->setProgress($userId, 'replace', __('Replacing application files...'), 72, 'running');

            $this->replaceFiles($root, base_path(), $protected);

            $composerAfter = File::exists(base_path('composer.json')) ? md5_file(base_path('composer.json')) : '';
            $composerChanged = $composerBefore !== $composerAfter;

            $this->setProgress($userId, 'migrate', __('Running database migrations...'), 85, 'running');

            Artisan::call('migrate', ['--force' => true]);

            $this->setProgress($userId, 'cleanup', __('Clearing caches...'), 95, 'running');

            Artisan::call('optimize:clear');
            Cache::forget('github_releases_' . str_replace('/', '_', $this->repo));
            Cache::forget('rj_options');

            rj_set_option('rj_version', ltrim((string) $release['version'], 'v'));
            Option::set('last_release', json_encode(array_merge($release, ['has_update' => false])), 'updates');

            Notification::where('action_url', route('admin.updates.index'))->delete();

            Artisan::call('up');

            File::delete($zipPath);
            File::deleteDirectory($extractPath);
            File::delete($codeBackupPath);

            $lock->release();

            $message = __('Update installed successfully. You are now on v:version.', ['version' => $release['version']]);
            if ($composerChanged) {
                $message .= ' ' . __('Note: composer.json changed — run `composer install --no-dev` to update vendor.');
            }

            $this->setProgress($userId, 'done', $message, 100, 'success');

            return $wantsJson ? response()->json(['success' => true, 'message' => $message]) : back()->with('success', $message);
        } catch (\Throwable $e) {
            $this->setProgress($userId, 'error', __('Rolling back...'), 96, 'running');

            try {
                Artisan::call('up');
            } catch (\Throwable $e2) {}

            if ($dbBackupFilename) {
                try {
                    $restoreResult = $backup->restore($dbBackupFilename, 'local');
                    if (!empty($restoreResult['success'])) {
                        $dbRestored = true;
                    } else {
                        Log::error('DB rollback failed: ' . ($restoreResult['message'] ?? ''));
                    }
                } catch (\Throwable $e3) {
                    Log::error('DB rollback exception: ' . $e3->getMessage());
                }
            }

            if (File::exists($codeBackupPath)) {
                try {
                    $this->restoreCodeBackup($codeBackupPath);
                } catch (\Throwable $e4) {
                    Log::error('Code rollback exception: ' . $e4->getMessage());
                }
                File::delete($codeBackupPath);
            }

            if (File::exists($zipPath)) File::delete($zipPath);
            if (File::isDirectory($extractPath)) File::deleteDirectory($extractPath);

            $lock->release();

            $errorMsg = $dbRestored
                ? __('Update failed: :msg. Site files and database restored from backup.', ['msg' => $e->getMessage()])
                : __('Update failed: :msg. Files restored; database rollback failed — restore manually from Backups.', ['msg' => $e->getMessage()]);

            $this->setProgress($userId, 'error', $errorMsg, 100, 'error');

            return $wantsJson ? response()->json(['success' => false, 'message' => $errorMsg], 500) : back()->with('error', $errorMsg);
        }
    }

    protected function setProgress(int $userId, string $step, string $label, int $percent, string $status): void
    {
        Cache::put('rj_update_progress_' . $userId, [
            'step' => $step,
            'label' => $label,
            'percent' => $percent,
            'status' => $status,
            'message' => $status === 'success' || $status === 'error' ? $label : '',
            'updated_at' => now()->toDateTimeString(),
        ], 900);
    }

    protected function pickDownloadUrl(array $release): ?string
    {
        $assets = $release['assets'] ?? [];

        if (is_array($assets)) {
            foreach ($assets as $asset) {
                if (!is_array($asset)) continue;
                $name = (string) ($asset['name'] ?? '');
                $url = (string) ($asset['browser_download_url'] ?? '');

                if ($url === '') continue;

                if (str_ends_with(strtolower($name), '.zip')) {
                    return $url;
                }
            }
        }

        return $release['zipball_url'] ?? null;
    }

    protected function createCodeBackup(string $zipPath, array $protected): void
    {
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException(__('Cannot create pre-update backup archive.'));
        }

        $base = base_path();

        foreach (@scandir($base) ?: [] as $item) {
            if ($item === '.' || $item === '..') continue;
            if (in_array($item, $protected, true)) continue;

            $full = $base . DIRECTORY_SEPARATOR . $item;

            if (is_dir($full)) {
                $this->addToZip($zip, $full, $item, $protected);
            } elseif (is_file($full)) {
                $zip->addFile($full, $item);
            }
        }

        $zip->close();
    }

    protected function addToZip(\ZipArchive $zip, string $dir, string $prefix, array $protected): void
    {
        foreach (@scandir($dir) ?: [] as $item) {
            if ($item === '.' || $item === '..') continue;

            $relative = $prefix . '/' . $item;

            foreach ($protected as $p) {
                if ($relative === $p || str_starts_with($relative, $p . '/')) {
                    continue 2;
                }
            }

            $full = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($full)) {
                $this->addToZip($zip, $full, $relative, $protected);
            } elseif (is_file($full)) {
                $zip->addFile($full, $relative);
            }
        }
    }

    protected function restoreCodeBackup(string $zipPath): void
    {
        $zip = new \ZipArchive();
        if ($zip->open($zipPath) !== true) {
            throw new \RuntimeException(__('Cannot open pre-update backup archive.'));
        }
        $zip->extractTo(base_path());
        $zip->close();
    }

    protected function replaceFiles(string $source, string $target, array $protected, string $prefix = ''): void
    {
        foreach (@scandir($source) ?: [] as $item) {
            if ($item === '.' || $item === '..') continue;

            $relative = $prefix === '' ? $item : $prefix . '/' . $item;

            foreach ($protected as $p) {
                if ($relative === $p || str_starts_with($relative, $p . '/')) {
                    continue 2;
                }
            }

            $src = $source . DIRECTORY_SEPARATOR . $item;
            $dst = $target . DIRECTORY_SEPARATOR . $item;

            if (is_dir($src)) {
                if (!is_dir($dst)) @mkdir($dst, 0755, true);
                $this->replaceFiles($src, $dst, $protected, $relative);
            } elseif (is_file($src)) {
                if (!@copy($src, $dst)) {
                    @chmod($dst, 0644);
                    @copy($src, $dst);
                }
            }
        }
    }

    protected function pickLatestRelease(array $releases): ?array
    {
        $best = null;

        foreach ($releases as $release) {
            if (!is_array($release) || !empty($release['draft']) || empty($release['tag_name'])) {
                continue;
            }

            if (!empty($release['prerelease'])) {
                continue;
            }

            if ($best === null || version_compare(ltrim($release['tag_name'], 'v'), ltrim($best['tag_name'], 'v'), '>')) {
                $best = $release;
            }
        }

        return $best;
    }

    protected function getCachedRelease(): ?array
    {
        $raw = Option::where('option_group', 'updates')
            ->where('option_name', 'last_release')
            ->value('option_value');

        if (!$raw) {
            return null;
        }

        $decoded = json_decode($raw, true);

        if (!is_array($decoded)) {
            return null;
        }

        if (!empty($decoded['version'])) {
            $decoded['has_update'] = version_compare(
                ltrim((string) $decoded['version'], 'v'),
                $this->currentVersion,
                '>'
            );
        }

        return $decoded;
    }
}