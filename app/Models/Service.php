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
}
