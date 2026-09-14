<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

trait FileUpload
{
    public function uploadFile(UploadedFile $file, string $dir, string $disk = 'public'): string
    {
        if (! in_array($disk, ['public', 'local'])) {
            throw new InvalidArgumentException("Invalid disk: $disk.");
        }

        $fileName = Str::uuid().'.'.$file->extension();
        $path = $file->storeAs("uploads/{$dir}", $fileName, $disk);

        if ($path === false) {
            throw new RuntimeException('Unable to upload file.');
        }

        return $path;
    }

    public function deleteFile(string $path, string $disk = 'public'): bool
    {
        if (! in_array($disk, ['public', 'local'])) {
            throw new InvalidArgumentException("Invalid disk: {$disk}.");
        }

        return Storage::disk($disk)->delete($path);
    }
}
