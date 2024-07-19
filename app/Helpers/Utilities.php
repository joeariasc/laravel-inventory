<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Utilities
{
    public static function uploadFile($key, $path): string
    {
        request()->file($key)->store($path);
        return request()->file($key)->hashName();
    }

    public static function deleteFile($path, $fileName): void
    {
        if ($fileName) {
            Storage::delete($path . '/' . $fileName);
        }
    }
}
