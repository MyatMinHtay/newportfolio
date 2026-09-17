<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Helper bridge for key-value site settings (ADR-004).
 */
class Settings
{
    /**
     * Get a setting by key, falling back to default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }

    /**
     * Set a setting by key and bust cache.
     */
    public static function set(string $key, ?string $value): void
    {
        Setting::set($key, $value);
    }
}
