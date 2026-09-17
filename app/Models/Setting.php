<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    public const CACHE_KEY = 'site_settings_map';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Retrieve all settings as a cached key-value array.
     *
     * @return array<string, string|null>
     */
    public static function allCached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()->pluck('value', 'key')->all();
        });
    }

    /**
     * Get a setting by key, falling back to default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = static::allCached();

        return array_key_exists($key, $settings) ? $settings[$key] : $default;
    }

    /**
     * Set a setting value and bust cache.
     */
    public static function set(string $key, ?string $value): static
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget(self::CACHE_KEY);

        return $setting;
    }

    /**
     * Bust the cached settings.
     */
    public static function bustCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
