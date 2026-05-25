<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

trait HandlesUploads
{
    protected function storeUpload(Request $request, string $field, string $directory, ?string $oldPath = null): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        $file = $request->file($field);
        $mime = (string) $file->getMimeType();

        // Non-raster (PDF, SVG, others): store as-is.
        if (! str_starts_with($mime, 'image/') || $mime === 'image/svg+xml') {
            return $file->store($directory, 'public');
        }

        // Image: resize down + recompress to keep storage/bandwidth low.
        $maxWidth = $this->maxWidthForDirectory($directory);
        $ext      = $this->normalizeExtension($file->getClientOriginalExtension(), $mime);
        $filename = $directory.'/'.Str::random(40).'.'.$ext;
        $target   = Storage::disk('public')->path($filename);

        $dir = dirname($target);
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $manager = new ImageManager(new Driver());
        $image   = $manager->decodePath($file->getRealPath());

        // Auto-rotate based on EXIF orientation (phone photos arrive sideways).
        $image->orient();

        // Only scale DOWN, never enlarge. Keeps aspect ratio.
        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        // Quality 85 untuk JPEG/WebP → ~70% lebih kecil tanpa perbedaan visual.
        $encoded = match ($ext) {
            'jpg', 'jpeg' => $image->encode(new JpegEncoder(quality: 85)),
            'webp'        => $image->encode(new WebpEncoder(quality: 85)),
            'png'         => $image->encode(new PngEncoder()), // lossless
            default       => $image->encode(new JpegEncoder(quality: 85)),
        };
        $encoded->save($target);

        return $filename;
    }

    /**
     * Lebar maksimum berdasarkan jenis upload (dari nama directory).
     * Profile/logo bisa kecil; hero background full-screen butuh besar.
     */
    private function maxWidthForDirectory(string $directory): int
    {
        $d = strtolower($directory);
        return match (true) {
            str_contains($d, 'favicon')                                 => 256,
            str_contains($d, 'logo')                                    => 800,
            str_contains($d, 'profile')                                 => 1200,
            str_contains($d, 'hero') || str_contains($d, 'background')  => 1920,
            default                                                     => 1600,
        };
    }

    private function normalizeExtension(string $original, string $mime): string
    {
        $ext = strtolower($original);
        return match (true) {
            in_array($ext, ['jpg', 'jpeg'])    => 'jpg',
            $ext === 'png'                     => 'png',
            $ext === 'webp'                    => 'webp',
            $mime === 'image/jpeg'             => 'jpg',
            $mime === 'image/png'              => 'png',
            $mime === 'image/webp'             => 'webp',
            default                            => 'jpg',
        };
    }
}
