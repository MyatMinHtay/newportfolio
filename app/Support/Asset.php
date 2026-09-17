<?php

namespace App\Support;

/**
 * Static asset path helpers for public/assets/.
 * Not a domain service — path utilities only (ADR-017).
 */
class Asset
{
    /**
     * Path relative to public/assets/, e.g. "css/app.css" or "libs/bootstrap/bootstrap.min.css".
     */
    public static function path(string $path): string
    {
        return asset('assets/'.ltrim($path, '/'));
    }

    public static function css(string $file): string
    {
        return self::path('css/'.$file);
    }

    public static function js(string $file): string
    {
        return self::path('js/'.$file);
    }

    public static function lib(string $path): string
    {
        return self::path('libs/'.$path);
    }

    public static function img(string $path): string
    {
        return self::path('img/'.$path);
    }
}
