<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'details',
        'icon',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public function iconClass(): string
    {
        $icon = trim((string) $this->icon);

        if ($icon === '') {
            return 'bi-layers';
        }

        return str_starts_with($icon, 'bi ') || str_starts_with($icon, 'bi-')
            ? $icon
            : 'bi-'.$icon;
    }

    public function renderedDetails(): string
    {
        return \Illuminate\Support\Str::markdown($this->details ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    /**
     * Extract top key bullet highlights from markdown details for compact display.
     *
     * @return array<int, string>
     */
    public function highlights(): array
    {
        if (empty($this->details)) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', (string) $this->details);
        $highlights = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^[-*]\s+(.+)$/', $line, $matches)) {
                $item = trim(strip_tags($matches[1]));
                // Remove bold markdown syntax for pill display
                $item = preg_replace('/\*\*(.*?)\*\*/', '$1', $item);
                if ($item !== '') {
                    $highlights[] = $item;
                }
            }
        }

        return $highlights;
    }
}
