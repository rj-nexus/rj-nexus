<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;

class MediaController extends Controller
{
    /** Maksimum fayl ölçüsü (KB). 51200 = 50 MB */
    private const MAX_KB = 51200;

    /** Növlər və onların uzantıları. Yeni format əlavə etmək üçün yalnız bura yaz. */
    private const TYPE_EXTS = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico', 'avif', 'tiff', 'tif', 'heic'],
        'video' => ['mp4', 'webm', 'mov', 'avi', 'mkv', 'm4v', 'wmv', 'flv', '3gp', 'mpeg', 'mpg', 'ogv'],
        'audio' => ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac', 'opus', 'wma'],
        'pdf' => ['pdf'],
        'document' => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'rtf', 'odt', 'ods', 'odp'],
        'archive' => ['zip', 'rar', '7z', 'tar', 'gz'],
    ];

    private const DOCUMENT_MIMES = [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/rtf',
        'text/rtf',
        'text/plain',
        'text/csv',
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.oasis.opendocument.presentation',
    ];

    private const ARCHIVE_MIMES = [
        'application/zip',
        'application/x-zip-compressed',
        'application/vnd.rar',
        'application/x-rar',
        'application/x-rar-compressed',
        'application/x-7z-compressed',
        'application/x-tar',
        'application/gzip',
        'application/x-gzip',
    ];

    /** Heç vaxt yüklənməsinə icazə verilməyən icra oluna bilən fayllar */
    private const FORBIDDEN_EXTS = [
        'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar',
        'exe', 'sh', 'bat', 'cmd', 'com', 'msi',
        'js', 'jsx', 'ts', 'tsx', 'mjs',
        'html', 'htm', 'xhtml', 'asp', 'aspx', 'jsp', 'py', 'pl', 'cgi', 'htaccess',
    ];

    public function index(Request $request)
    {
        $query = Media::with('uploader')->latest();

        $this->applyTypeFilter($query, (string) $request->input('type', ''));
        $this->applySearch($query, (string) $request->input('search', ''));

        $media = $query->paginate(24)->withQueryString();

        $stats = [
            'total' => Media::count(),
            'images' => Media::where('mime_type', 'like', 'image/%')->count(),
            'videos' => Media::where('mime_type', 'like', 'video/%')->count(),
            'documents' => Media::where('mime_type', 'not like', 'image/%')
                ->where('mime_type', 'not like', 'video/%')
                ->where('mime_type', 'not like', 'audio/%')
                ->count(),
            'size' => Media::sum('size'),
        ];

        return view('admin.media.index', compact('media', 'stats'));
    }

    public function picker(Request $request)
    {
        $query = Media::latest();

        $this->applyTypeFilter($query, (string) $request->input('type', ''));
        $this->applySearch($query, (string) $request->input('search', ''));

        $total = $query->count();
        $items = $query->paginate(30)->items();

        $items = collect($items)->map(fn ($m) => [
            'id' => $m->id,
            'url' => $m->url,
            'original_name' => $m->original_name,
            'mime_type' => $m->mime_type,
            'size_human' => $m->humanSize(),
            'type' => $this->kindOf((string) $m->mime_type, (string) $m->filename),
            'ext' => strtolower(pathinfo((string) $m->filename, PATHINFO_EXTENSION)),
            'alt_text' => $m->alt_text,
        ])->values()->toArray();

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => [
                'file',
                'max:' . self::MAX_KB,
                File::types($this->allowedExtensions())->max(self::MAX_KB),
            ],
        ]);

        $uploaded = [];
        $errors = [];

        foreach ($request->file('files') as $file) {
            try {
                $uploaded[] = $this->saveFile($file, $request->user()->id);
            } catch (\Throwable $e) {
                $errors[] = $file->getClientOriginalName() . ': ' . $e->getMessage();
            }
        }

        if (empty($uploaded)) {
            return back()->with('error', __('No files were uploaded. :errors', ['errors' => implode(', ', $errors)]));
        }

        $message = __('Uploaded :count file(s).', ['count' => count($uploaded)]);

        if (!empty($errors)) {
            $message .= ' ' . __(':count failed.', ['count' => count($errors)]);
        }

        return redirect()->route('admin.media.index')->with('success', $message);
    }

    public function edit(Media $medium)
    {
        return view('admin.media.edit', ['media' => $medium]);
    }

    public function update(Request $request, Media $medium)
    {
        $data = $request->validate([
            'alt_text' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $medium->update($data);

        return back()->with('success', __('Media updated.'));
    }

    public function destroy(Media $medium)
    {
        $this->deleteFile($medium);

        return back()->with('success', __('Media deleted.'));
    }

    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:rj_media,id'],
        ]);

        $items = Media::whereIn('id', $data['ids'])->get();
        $count = 0;

        foreach ($items as $item) {
            $this->deleteFile($item);
            $count++;
        }

        return back()->with('success', __(':count item(s) deleted.', ['count' => $count]));
    }

    /* ------------------------------------------------------------------ */
    /*  Köməkçi metodlar                                                   */
    /* ------------------------------------------------------------------ */

    private function allowedExtensions(): array
    {
        return array_values(array_unique(array_merge(...array_values(self::TYPE_EXTS))));
    }

    /**
     * Mime tipinə və uzantıya görə faylın növünü təyin edir.
     */
    private function kindOf(string $mime, string $filename): string
    {
        $mime = strtolower($mime);
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (str_starts_with($mime, 'image/')) { return 'image'; }
        if (str_starts_with($mime, 'video/')) { return 'video'; }
        if (str_starts_with($mime, 'audio/')) { return 'audio'; }
        if ($mime === 'application/pdf') { return 'pdf'; }
        if (in_array($mime, self::ARCHIVE_MIMES, true)) { return 'archive'; }
        if (in_array($mime, self::DOCUMENT_MIMES, true)) { return 'document'; }

        foreach (self::TYPE_EXTS as $kind => $exts) {
            if (in_array($ext, $exts, true)) { return $kind; }
        }

        return 'document';
    }

    /**
     * Növ filtri: həm mime tipinə, həm də fayl uzantısına görə axtarır
     * (bəzi serverlərdə avi, mkv, mov mime-i fərqli tanınır).
     */
    private function applyTypeFilter($query, string $type): void
    {
        if ($type === '' || !isset(self::TYPE_EXTS[$type])) {
            return;
        }

        $exts = self::TYPE_EXTS[$type];

        $query->where(function ($q) use ($type, $exts) {
            switch ($type) {
                case 'image':
                case 'video':
                case 'audio':
                    $q->where('mime_type', 'like', $type . '/%');
                    break;
                case 'pdf':
                    $q->where('mime_type', 'application/pdf');
                    break;
                case 'document':
                    $q->whereIn('mime_type', self::DOCUMENT_MIMES);
                    break;
                case 'archive':
                    $q->whereIn('mime_type', self::ARCHIVE_MIMES);
                    break;
            }

            foreach ($exts as $ext) {
                $q->orWhere('filename', 'like', '%.' . $ext);
            }
        });
    }

    private function applySearch($query, string $search): void
    {
        $search = trim($search);

        if ($search === '') {
            return;
        }

        $query->where(function ($q) use ($search) {
            $q->where('original_name', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('alt_text', 'like', "%{$search}%");
        });
    }

    protected function saveFile($file, ?int $userId): Media
    {
        $original = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();

        // TƏHLÜKƏSİZLİK: icra oluna bilən fayllar qəti qadağandır
        if (in_array($extension, self::FORBIDDEN_EXTS, true)) {
            throw new \Exception('Forbidden file type.');
        }

        // Qoşa uzantı hiyləsinin qarşısı (məs. shell.php.jpg)
        $nameOnly = strtolower(pathinfo($original, PATHINFO_FILENAME));
        foreach (self::FORBIDDEN_EXTS as $bad) {
            if (str_ends_with($nameOnly, '.' . $bad)) {
                throw new \Exception('Forbidden file type.');
            }
        }

        $folder = 'uploads/' . date('Y/m');
        $basename = Str::slug(pathinfo($original, PATHINFO_FILENAME));
        $basename = $basename !== '' ? $basename : 'file';
        $basename = substr($basename, 0, 80);

        $destPath = public_path($folder);

        if (!is_dir($destPath)) {
            mkdir($destPath, 0755, true);
        }

        $isImage = str_starts_with((string) $mime, 'image/') && !in_array($extension, ['svg', 'gif', 'ico', 'heic', 'avif', 'tiff', 'tif'], true);
        $canWebP = function_exists('imagewebp') && function_exists('imagecreatefromstring');

        if ($isImage && $canWebP) {
            $imageContent = file_get_contents($file->getRealPath());
            $image = @imagecreatefromstring($imageContent);

            if ($image !== false) {
                $width = imagesx($image);
                $height = imagesy($image);
                $maxWidth = 1920;
                $newWidth = $width;
                $newHeight = $height;

                if ($width > $maxWidth) {
                    $newWidth = $maxWidth;
                    $newHeight = (int) floor($height * ($maxWidth / $width));
                    $resized = imagecreatetruecolor($newWidth, $newHeight);
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                    $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                    imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
                    imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagedestroy($image);
                    $image = $resized;
                } else {
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                }

                $filename = $basename . '-' . Str::random(8) . '.webp';
                $fullPath = $destPath . '/' . $filename;

                if (imagewebp($image, $fullPath, 85)) {
                    imagedestroy($image);

                    return Media::create([
                        'filename' => $filename,
                        'original_name' => $original,
                        'path' => $folder . '/' . $filename,
                        'url' => asset($folder . '/' . $filename),
                        'mime_type' => 'image/webp',
                        'size' => filesize($fullPath),
                        'width' => $newWidth,
                        'height' => $newHeight,
                        'title' => pathinfo($original, PATHINFO_FILENAME),
                        'uploaded_by' => $userId,
                    ]);
                }

                imagedestroy($image);
            }
        }

        $filename = $basename . '-' . Str::random(8) . '.' . $extension;
        $file->move($destPath, $filename);
        $fullPath = $destPath . '/' . $filename;
        $dimensions = str_starts_with((string) $mime, 'image/') ? @getimagesize($fullPath) : false;

        return Media::create([
            'filename' => $filename,
            'original_name' => $original,
            'path' => $folder . '/' . $filename,
            'url' => asset($folder . '/' . $filename),
            'mime_type' => $mime,
            'size' => filesize($fullPath),
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
            'title' => pathinfo($original, PATHINFO_FILENAME),
            'uploaded_by' => $userId,
        ]);
    }

    protected function deleteFile(Media $media): void
    {
        $path = public_path($media->path);

        if (file_exists($path)) {
            @unlink($path);
        }

        $media->delete();
    }
}