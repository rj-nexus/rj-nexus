<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunAutoBackupCommand extends Command
{
    protected $signature = 'backup:auto {--force : Run backup regardless of the configured schedule}';

    protected $description = 'Run an automatic backup based on the configured schedule.';

    public function handle(BackupService $backup): int
    {
        if (rj_get_option('backup_mode', 'manual') !== 'auto') {
            $this->line('Auto backup is disabled.');
            return self::SUCCESS;
        }

        $schedule = rj_get_option('backup_schedule', 'daily');
        $force = (bool) $this->option('force');

        if (!$force && !$this->isDue($schedule)) {
            $this->line("Schedule '{$schedule}' is not due right now.");
            return self::SUCCESS;
        }

        $includeDb = rj_get_option('backup_include_db', '1') === '1';
        $includeFiles = rj_get_option('backup_include_files', '1') === '1';

        if (!$includeDb && !$includeFiles) {
            $this->error('Both database and files are disabled in backup settings.');
            Log::warning('Auto backup skipped: both database and files are disabled.');
            return self::FAILURE;
        }

        $this->info('Starting automatic backup...');

        $result = match (true) {
            $includeDb && $includeFiles => $backup->createFullBackup('local'),
            $includeDb => $backup->createDatabaseBackup('local'),
            default => $backup->createFilesBackup('local'),
        };

        if ($result['success']) {
            $this->info("Backup created: {$result['filename']}");
            Log::info("Auto backup succeeded: {$result['filename']}");
            return self::SUCCESS;
        }

        $this->error("Backup failed: {$result['message']}");
        Log::error("Auto backup failed: {$result['message']}");
        return self::FAILURE;
    }

    private function isDue(string $schedule): bool
    {
        $now = now();

        return match ($schedule) {
            'daily' => true,
            'weekly' => $now->dayOfWeek === 0,
            'monthly' => $now->day === 1,
            default => false,
        };
    }
}