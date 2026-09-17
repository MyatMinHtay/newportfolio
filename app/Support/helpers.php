<?php

use App\Support\Asset;
use App\Support\Url;

if (! function_exists('project')) {
    /**
     * Read from config/project.php.
     */
    function project(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return config('project');
        }

        return config('project.'.$key, $default);
    }
}

if (! function_exists('project_asset')) {
    /**
     * Public asset under public/assets/ (css, js, libs, img, …).
     */
    function project_asset(string $path): string
    {
        return Asset::path($path);
    }
}

if (! function_exists('project_url')) {
    /**
     * Build a site URL path helper (thin wrapper).
     */
    function project_url(string $path = '/'): string
    {
        return Url::to($path);
    }
}
