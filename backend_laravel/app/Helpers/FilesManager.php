<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

/**
 * Upload file, return url file uploaded
 * @param mixed $file
 * @param string $path
 * @return string
 */
if (!function_exists('uploadFile')) {
    function uploadFile(UploadedFile $file, string $slug, string $type, string $disk = 'images'): string
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = $slug . '--' . $type . $extension;

        Storage::disk($disk)->put($fileName, file_get_contents($file));

        return $url = Storage::disk($disk)->url($fileName);
    }
}

/** Handle Delete File
 * @param string $path
 * @return void
 */
if (!function_exists('deleteFile')) {
    function deleteFile(string $url, string $disk = 'images'): void
    {
        // Trích xuất phần đường dẫn tương đối từ URL
        $path = parse_url($url, PHP_URL_PATH);
        $relativePath = ltrim($path, '/' . $disk . '/');

        if (Storage::disk($disk)->exists($relativePath)) {
            Storage::disk($disk)->delete($relativePath);
        }
    }
}
