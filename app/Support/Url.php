<?php

namespace App\Support;

/**
 * URL helpers. No routing business rules (ADR-017).
 */
class Url
{
    public static function to(string $path = '/'): string
    {
        return url('/'.ltrim($path, '/'));
    }

    public static function admin(string $path = ''): string
    {
        $path = trim($path, '/');

        return $path === '' ? url('/admin') : url('/admin/'.$path);
    }

    public static function home(): string
    {
        return url('/');
    }
}
