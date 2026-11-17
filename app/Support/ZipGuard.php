<?php

namespace App\Support;

class ZipGuard
{
    public static function inspect(\ZipArchive $zip, int $maxTotalBytes = 524288000, int $maxFiles = 10000): array
    {
        $totalSize = 0;
        $count = 0;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);

            if ($stat === false) {
                return ['ok' => false, 'message' => __('Could not read ZIP entry metadata.')];
            }

            $name = (string) ($stat['name'] ?? '');

            if ($name === '') {
                continue;
            }

            if (str_starts_with($name, '/') || str_starts_with($name, '\\')) {
                return ['ok' => false, 'message' => __('Blocked: absolute path in ZIP entry (:name).', ['name' => $name])];
            }

            if (preg_match('#(^|[/\\\\])\.\.([/\\\\]|$)#', $name)) {
                return ['ok' => false, 'message' => __('Blocked: directory traversal in ZIP entry (:name).', ['name' => $name])];
            }

            if (preg_match('#^[a-zA-Z]:#', $name)) {
                return ['ok' => false, 'message' => __('Blocked: drive-letter path in ZIP entry (:name).', ['name' => $name])];
            }

            $external = (int) ($stat['external_attributes'] ?? 0);
            $fileType = $external & 0xF000;

            if ($fileType === 0xA000) {
                return ['ok' => false, 'message' => __('Blocked: symlinks are not allowed inside ZIP archives.')];
            }

            $totalSize += (int) ($stat['size'] ?? 0);
            $count++;
        }

        if ($count > $maxFiles) {
            return ['ok' => false, 'message' => __('Blocked: too many files in archive (limit :limit).', ['limit' => $maxFiles])];
        }

        if ($totalSize > $maxTotalBytes) {
            return ['ok' => false, 'message' => __('Blocked: uncompressed size exceeds :mb MB limit.', ['mb' => (int) round($maxTotalBytes / 1048576)])];
        }

        return ['ok' => true, 'total_size' => $totalSize, 'count' => $count];
    }

    public static function extract(\ZipArchive $zip, string $target): array
    {
        if (!is_dir($target) && !@mkdir($target, 0755, true) && !is_dir($target)) {
            return ['ok' => false, 'message' => __('Could not create extraction directory.')];
        }

        if (!$zip->extractTo($target)) {
            return ['ok' => false, 'message' => __('Could not extract ZIP archive.')];
        }

        return ['ok' => true];
    }
}