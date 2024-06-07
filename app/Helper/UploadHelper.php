<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class UploadHelper
{
    /**
     * @param Request $request
     * @param string $field
     * @param string $path
     * @return string|null
     */
    public static function upload(Request $request, string $field = 'file', string $path = 'files'): ?string
    {
        if (!$request->is_upload) {
            return $request->$field;
        }

        if ($request->file($field) !== null) {
            return Storage::disk()->put($path, $request->file($field));
        }

        return null;
    }

    /**
     * @param string|null $file
     * @return string|null
     */
    public static function url(string $file = null): ?string
    {
        if (Str::isUrl($file)) {
            return $file;
        }

        if ($file !== null && Storage::disk()->exists($file)) {
            return Storage::url($file);
        }

        return null;
    }
}
