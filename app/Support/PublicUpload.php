<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Public-disk image uploads. Path utilities only — not a domain service (ADR-017).
 */
class PublicUpload
{
    public static function storeImage(UploadedFile $file, string $directory): string
    {
        $allowed = config('project.upload_limits.allowed_image_mimes', ['jpg', 'jpeg', 'png', 'webp']);
        $extension = strtolower((string) ($file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'jpg'));

        if (! in_array($extension, $allowed, true)) {
            $extension = 'jpg';
        }

        $filename = Str::uuid()->toString().'.'.$extension;

        return $file->storeAs($directory, $filename, 'public');
    }

    public static function storePdf(UploadedFile $file, string $directory): string
    {
        $filename = Str::uuid()->toString().'.pdf';

        return $file->storeAs($directory, $filename, 'public');
    }

    public static function delete(?string $path): void
    {
        if (! $path || str_starts_with($path, 'assets/')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
