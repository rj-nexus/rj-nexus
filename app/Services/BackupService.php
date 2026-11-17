<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BackupService
{
    protected string $basePath;

    public function __construct()
    {
        $this->basePath = storage_path('app/backups');
        $this->ensureDirs();
    }

    protected function ensureDirs(): void
    {
        foreach (['local', 'download'] as $type) {
            $dir = $this->basePath . '/' . $type;
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }
    }

    public function create(string $storage = 'local', ?int $userId = null): array
    {
        return $this->createFullBackup($storage, $userId);
    }

    public function createDatabaseBackup(string $storage = 'local', ?int $userId = null): array
    {
        $this->setProgress($userId, 'init', __('Preparing database backup...'), 5, 'running');

        try {
            $filename = 'db-' . date('Y-m-d-H-i-s') . '-' . Str::random(4) . '.sql';
            $path = $this->basePath . '/' . $storage . '/' . $filename;

            $this->setProgress($userId, 'dump', __('Dumping database tables...'), 40, 'running');
            $this->dumpDatabase($path);

            if (!File::exists($path) || File::size($path) === 0) {
                throw new \RuntimeException(__('Database dump is empty.'));
            }

            $this->setProgress($userId, 'cleanup', __('Applying retention policy...'), 90, 'running');
            $this->applyRetention($storage);

            $this->setProgress($userId, 'done', __('Database backup created successfully.'), 100, 'success');

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'size' => File::size($path),
                'message' => __('Database backup created.'),
            ];
        } catch (\Throwable $e) {
            if (File::exists($path)) File::delete($path);
            $this->setProgress($userId, 'error', $e->getMessage(), 100, 'error');
            return ['success' => false, 'message' => __('Backup failed: :msg', ['msg' => $e->getMessage()])];
        }
    }

    public function createFilesBackup(string $storage = 'local', ?int $userId = null): array
    {
        $this->setProgress($userId, 'init', __('Preparing files backup...'), 5, 'running');

        if (!class_exists('ZipArchive')) {
            $this->setProgress($userId, 'error', __('ZipArchive not available.'), 100, 'error');
            return ['success' => false, 'message' => __('ZipArchive PHP extension is not enabled.')];
        }

        $path = null;

        try {
            $filename = 'files-' . date('Y-m-d-H-i-s') . '-' . Str::random(4) . '.zip';
            $path = $this->basePath . '/' . $storage . '/' . $filename;

            $zip = new \ZipArchive();
            if ($zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException(__('Could not create ZIP archive.'));
            }

            $this->setProgress($userId, 'uploads', __('Archiving uploads...'), 30, 'running');
            $uploads = public_path('uploads');
            if (File::isDirectory($uploads)) {
                $this->addDirectoryToZip($zip, $uploads, 'uploads');
            }

            $this->setProgress($userId, 'storage', __('Archiving storage...'), 70, 'running');
            $storageApp = storage_path('app/public');
            if (File::isDirectory($storageApp)) {
                $this->addDirectoryToZip($zip, $storageApp, 'storage/app/public');
            }

            $zip->close();

            $this->setProgress($userId, 'cleanup', __('Applying retention policy...'), 95, 'running');
            $this->applyRetention($storage);

            $this->setProgress($userId, 'done', __('Files backup created successfully.'), 100, 'success');

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'size' => File::size($path),
                'message' => __('Files backup created.'),
            ];
        } catch (\Throwable $e) {
            if ($path && File::exists($path)) File::delete($path);
            $this->setProgress($userId, 'error', $e->getMessage(), 100, 'error');
            return ['success' => false, 'message' => __('Backup failed: :msg', ['msg' => $e->getMessage()])];
        }
    }

    public function createFullBackup(string $storage = 'local', ?int $userId = null): array
    {
        $this->setProgress($userId, 'init', __('Preparing full backup...'), 5, 'running');

        if (!class_exists('ZipArchive')) {
            $this->setProgress($userId, 'error', __('ZipArchive not available.'), 100, 'error');
            return ['success' => false, 'message' => __('ZipArchive PHP extension is not enabled.')];
        }

        $sqlPath = storage_path('app/temp-backup-' . Str::random(10) . '.sql');
        $path = null;

        try {
            $this->setProgress($userId, 'dump', __('Dumping database...'), 20, 'running');
            $this->dumpDatabase($sqlPath);

            if (!File::exists($sqlPath) || File::size($sqlPath) === 0) {
                throw new \RuntimeException(__('Database dump is empty.'));
            }

            $filename = 'full-' . date('Y-m-d-H-i-s') . '-' . Str::random(4) . '.zip';
            $path = $this->basePath . '/' . $storage . '/' . $filename;

            $zip = new \ZipArchive();
            if ($zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException(__('Could not create ZIP archive.'));
            }

            $zip->addFile($sqlPath, 'database.sql');

            $this->setProgress($userId, 'uploads', __('Archiving uploads...'), 45, 'running');
            $uploads = public_path('uploads');
            if (File::isDirectory($uploads)) {
                $this->addDirectoryToZip($zip, $uploads, 'uploads');
            }

            $this->setProgress($userId, 'storage', __('Archiving storage...'), 80, 'running');
            $storageApp = storage_path('app/public');
            if (File::isDirectory($storageApp)) {
                $this->addDirectoryToZip($zip, $storageApp, 'storage/app/public');
            }

            $zip->close();

            if (File::exists($sqlPath)) File::delete($sqlPath);

            $this->setProgress($userId, 'cleanup', __('Applying retention policy...'), 95, 'running');
            $this->applyRetention($storage);

            $this->setProgress($userId, 'done', __('Full backup created successfully.'), 100, 'success');

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'size' => File::size($path),
                'message' => __('Full backup created.'),
            ];
        } catch (\Throwable $e) {
            if (File::exists($sqlPath)) File::delete($sqlPath);
            if ($path && File::exists($path)) File::delete($path);
            $this->setProgress($userId, 'error', $e->getMessage(), 100, 'error');
            return ['success' => false, 'message' => __('Backup failed: :msg', ['msg' => $e->getMessage()])];
        }
    }

    public function getBackups(string $type = 'local'): array
    {
        $dir = $this->basePath . '/' . $type;

        if (!File::isDirectory($dir)) {
            return [];
        }

        $files = File::files($dir);
        $result = [];

        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (!in_array($ext, ['zip', 'sql'], true)) continue;

            $result[] = [
                'filename' => $file->getFilename(),
                'size' => $file->getSize(),
                'size_human' => $this->formatSize($file->getSize()),
                'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                'timestamp' => $file->getMTime(),
                'extension' => $ext,
            ];
        }

        usort($result, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return $result;
    }

    public function delete(string $filename, string $type = 'local'): array
    {
        $path = $this->basePath . '/' . $type . '/' . basename($filename);

        if (File::exists($path)) {
            File::delete($path);
            return ['success' => true, 'message' => __('Backup deleted.')];
        }

        return ['success' => false, 'message' => __('Backup not found.')];
    }

    public function restore(string $filename, string $type = 'local', ?int $userId = null): array
    {
        $path = $this->basePath . '/' . $type . '/' . basename($filename);

        if (!File::exists($path)) {
            return ['success' => false, 'message' => __('Backup not found.')];
        }

        $this->setProgress($userId, 'init', __('Preparing restore...'), 2, 'running');
        $tempDir = null;

        try {
            if (str_ends_with(strtolower($filename), '.sql')) {
                $this->restoreDatabase($path, $userId, 5, 100);
                $this->setProgress($userId, 'done', __('Database restored successfully.'), 100, 'success');
                return ['success' => true, 'message' => __('Database restored successfully.')];
            }

            $tempDir = storage_path('app/temp-restore-' . time() . '-' . Str::random(4));
            File::ensureDirectoryExists($tempDir);

            $this->setProgress($userId, 'extract', __('Extracting archive...'), 5, 'running');

            $zip = new \ZipArchive();
            if ($zip->open($path) !== true) {
                throw new \RuntimeException(__('Could not open ZIP file.'));
            }
            $zip->extractTo($tempDir);
            $zip->close();

            $sqlFile = $tempDir . '/database.sql';
            $uploadsDir = $tempDir . '/uploads';
            $storageDir = $tempDir . '/storage/app/public';

            if (File::exists($sqlFile)) {
                $this->restoreDatabase($sqlFile, $userId, 10, 70);
            }

            if (File::isDirectory($uploadsDir)) {
                $this->setProgress($userId, 'uploads', __('Restoring uploads...'), 75, 'running');
                File::copyDirectory($uploadsDir, public_path('uploads'));
            }

            if (File::isDirectory($storageDir)) {
                $this->setProgress($userId, 'storage', __('Restoring storage...'), 90, 'running');
                File::copyDirectory($storageDir, storage_path('app/public'));
            }

            File::deleteDirectory($tempDir);
            $this->setProgress($userId, 'done', __('Restore completed successfully.'), 100, 'success');

            return ['success' => true, 'message' => __('Restored successfully.')];
        } catch (\Throwable $e) {
            if ($tempDir && File::isDirectory($tempDir)) {
                File::deleteDirectory($tempDir);
            }
            $this->setProgress($userId, 'error', $e->getMessage(), 100, 'error');
            return ['success' => false, 'message' => __('Restore failed: :msg', ['msg' => $e->getMessage()])];
        }
    }

    public function progress(int $userId): array
    {
        return Cache::get('rj_backup_progress_' . $userId, [
            'step' => 'idle',
            'label' => '',
            'percent' => 0,
            'status' => 'idle',
        ]);
    }

    protected function setProgress(?int $userId, string $step, string $label, int $percent, string $status): void
    {
        if ($userId === null) {
            return;
        }

        Cache::put('rj_backup_progress_' . $userId, [
            'step' => $step,
            'label' => $label,
            'percent' => max(0, min(100, $percent)),
            'status' => $status,
        ], 600);
    }

    protected function applyRetention(string $type): void
    {
        $limit = $type === 'download'
            ? (int) rj_get_option('backup_download_limit', 2)
            : (int) rj_get_option('backup_local_limit', 5);

        if ($type === 'download') {
            $limit = min(3, max(1, $limit));
        } else {
            $limit = max(1, $limit);
        }

        $backups = $this->getBackups($type);

        if (count($backups) > $limit) {
            foreach (array_slice($backups, $limit) as $b) {
                File::delete($this->basePath . '/' . $type . '/' . $b['filename']);
            }
        }
    }

    protected function dumpDatabase(string $path): void
    {
        $conn = DB::connection();
        $driver = $conn->getDriverName();

        if ($driver !== 'mysql') {
            throw new \RuntimeException(__('Database driver :driver is not supported for backup.', ['driver' => $driver]));
        }

        $handle = fopen($path, 'w+');
        if (!$handle) {
            throw new \RuntimeException(__('Cannot open dump file for writing.'));
        }

        $pdo = $conn->getPdo();
        $originalBuffered = true;

        try {
            try {
                $originalBuffered = (bool) $pdo->getAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY);
            } catch (\Throwable $e) {}

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
            fwrite($handle, "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n");

            $tables = $conn->select('SHOW TABLES');
            $dbName = $conn->getDatabaseName();
            $key = 'Tables_in_' . $dbName;

            foreach ($tables as $table) {
                $tableName = $table->$key ?? array_values((array) $table)[0];
                $createTable = $conn->select("SHOW CREATE TABLE `$tableName`");
                $createSql = $createTable[0]->{'Create Table'} ?? '';

                fwrite($handle, "\n-- Table: `$tableName`\n");
                fwrite($handle, "DROP TABLE IF EXISTS `$tableName`;\n");
                fwrite($handle, $createSql . ";\n\n");

                try {
                    $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
                } catch (\Throwable $e) {}

                $stmt = $pdo->query("SELECT * FROM `$tableName`");
                $batch = [];

                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $keys = array_map(fn($k) => "`$k`", array_keys($row));
                    $values = array_map(function ($v) use ($pdo) {
                        if ($v === null) return 'NULL';
                        return $pdo->quote((string) $v);
                    }, array_values($row));

                    $batch[] = "INSERT INTO `$tableName` (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ");";

                    if (count($batch) >= 500) {
                        fwrite($handle, implode("\n", $batch) . "\n");
                        $batch = [];
                    }
                }

                if (!empty($batch)) {
                    fwrite($handle, implode("\n", $batch) . "\n");
                }

                fwrite($handle, "\n");

                try {
                    $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, $originalBuffered);
                } catch (\Throwable $e) {}
            }

            fwrite($handle, "\nSET FOREIGN_KEY_CHECKS=1;\n");
        } finally {
            fclose($handle);
            try {
                $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, $originalBuffered);
            } catch (\Throwable $e) {}
        }
    }

    protected function restoreDatabase(string $sqlFile, ?int $userId = null, int $startPct = 0, int $endPct = 100): void
    {
        if (!File::exists($sqlFile)) {
            throw new \RuntimeException(__('SQL file not found.'));
        }

        $fileSize = (int) File::size($sqlFile);
        if ($fileSize === 0) {
            throw new \RuntimeException(__('SQL file is empty.'));
        }

        $handle = fopen($sqlFile, 'r');
        if ($handle === false) {
            throw new \RuntimeException(__('Cannot open SQL file for reading.'));
        }

        $buffer = '';
        $bytesRead = 0;
        $statementCount = 0;
        $lastReportPct = -1;
        $lastReportTime = 0.0;

        $inSingle = false;
        $inDouble = false;
        $inBacktick = false;
        $inLineComment = false;
        $inBlockComment = false;
        $escaped = false;

        $span = max(1, $endPct - $startPct);

        try {
            while (!feof($handle)) {
                $chunk = fread($handle, 65536);
                if ($chunk === false || $chunk === '') {
                    break;
                }

                $bytesRead += strlen($chunk);
                $len = strlen($chunk);

                for ($i = 0; $i < $len; $i++) {
                    $c = $chunk[$i];
                    $next = ($i + 1 < $len) ? $chunk[$i + 1] : '';

                    if ($escaped) {
                        $buffer .= $c;
                        $escaped = false;
                        continue;
                    }

                    if ($inLineComment) {
                        if ($c === "\n") {
                            $inLineComment = false;
                            $buffer .= ' ';
                        }
                        continue;
                    }

                    if ($inBlockComment) {
                        if ($c === '*' && $next === '/') {
                            $inBlockComment = false;
                            $i++;
                        }
                        continue;
                    }

                    if (!$inSingle && !$inDouble && !$inBacktick) {
                        if ($c === '-' && $next === '-') {
                            $inLineComment = true;
                            $i++;
                            continue;
                        }
                        if ($c === '/' && $next === '*') {
                            $inBlockComment = true;
                            $i++;
                            continue;
                        }
                    }

                    if ($c === '\\') {
                        $escaped = true;
                        $buffer .= $c;
                        continue;
                    }

                    if ($c === "'" && !$inDouble && !$inBacktick) {
                        $inSingle = !$inSingle;
                    } elseif ($c === '"' && !$inSingle && !$inBacktick) {
                        $inDouble = !$inDouble;
                    } elseif ($c === '`' && !$inSingle && !$inDouble) {
                        $inBacktick = !$inBacktick;
                    }

                    $buffer .= $c;

                    if ($c === ';' && !$inSingle && !$inDouble && !$inBacktick) {
                        $sql = trim($buffer);
                        $buffer = '';

                        if ($sql !== '' && $sql !== ';') {
                            DB::unprepared($sql);
                            $statementCount++;
                        }

                        $now = microtime(true);
                        if ($userId !== null && ($now - $lastReportTime >= 1.5 || $statementCount % 100 === 0)) {
                            $pct = $startPct + (int) (($bytesRead / $fileSize) * $span);
                            $pct = max($startPct, min($endPct - 1, $pct));
                            if ($pct !== $lastReportPct) {
                                $lastReportPct = $pct;
                                $this->setProgress(
                                    $userId,
                                    'database',
                                    __('Restoring database... :n statements', ['n' => number_format($statementCount)]),
                                    $pct,
                                    'running'
                                );
                            }
                            $lastReportTime = $now;
                        }
                    }
                }
            }

            $tail = trim($buffer);
            if ($tail !== '' && $tail !== ';') {
                DB::unprepared($tail);
                $statementCount++;
            }

            if ($userId !== null) {
                $this->setProgress(
                    $userId,
                    'database',
                    __('Database restored (:n statements)', ['n' => number_format($statementCount)]),
                    $endPct,
                    'running'
                );
            }
        } finally {
            fclose($handle);
        }
    }

    protected function addDirectoryToZip(\ZipArchive $zip, string $dir, string $base): void
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) continue;
            $filePath = $file->getRealPath();
            $relative = $base . '/' . substr($filePath, strlen($dir) + 1);
            $zip->addFile($filePath, str_replace('\\', '/', $relative));
        }
    }

    protected function formatSize(float $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}