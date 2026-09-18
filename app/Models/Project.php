<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'cover_image',
        'project_url',
        'repo_url',
        'video_url',
        'tech_stack',
        'is_featured',
        'is_published',
        'sort_order',
        'started_at',
        'ended_at',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'started_at' => 'date',
            'ended_at' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    public function hasCoverImage(): bool
    {
        return filled($this->cover_image);
    }

    public function isFreelance(): bool
    {
        return in_array($this->slug, ['dream-comic', 'km-explorer', 'travel-and-tour'], true);
    }

    public function isPreview(): bool
    {
        return $this->slug === 'dev-toolkit';
    }

    public function engagementLabel(): string
    {
        if ($this->isPreview()) {
            return 'Preview';
        }

        return $this->isFreelance() ? 'Freelance' : 'Product';
    }

    public function coverKey(): string
    {
        return match ($this->slug) {
            'morningstar-translation-mm' => 'mns',
            'nexus-vpn-panel' => 'vpn',
            'dream-comic' => 'comic',
            'km-explorer', 'travel-and-tour' => 'travel',
            'laravel-portfolio-cms' => 'cms',
            'dev-toolkit' => 'toolkit',
            default => 'default',
        };
    }

    public function coverIcon(): string
    {
        return match ($this->coverKey()) {
            'mns' => 'bi-book',
            'vpn' => 'bi-shield-lock',
            'comic' => 'bi-journal-richtext',
            'travel' => 'bi-geo-alt',
            'cms' => 'bi-layout-text-window',
            'toolkit' => 'bi-tools',
            default => 'bi-code-slash',
        };
    }

    public function filterTags(): string
    {
        $tags = ['all', $this->isFreelance() ? 'freelance' : 'product'];
        $stack = strtolower(implode(' ', $this->tech_stack ?? []));

        if (str_contains($stack, 'laravel') || str_contains($stack, 'php')) {
            $tags[] = 'laravel';
        }

        return implode(' ', $tags);
    }

    public function isExternalUrl(): bool
    {
        return is_string($this->project_url)
            && (str_starts_with($this->project_url, 'http://') || str_starts_with($this->project_url, 'https://'));
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
                return $this->cover_image;
            }

            if (str_starts_with($this->cover_image, 'assets/') || str_starts_with($this->cover_image, 'storage/')) {
                return asset(ltrim($this->cover_image, '/'));
            }

            return Storage::disk('public')->url($this->cover_image);
        }

        return asset('assets/img/projects/thumbnail1.png');
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        // Already player URL
        if (str_contains($this->video_url, 'player.vimeo.com') || str_contains($this->video_url, 'youtube.com/embed')) {
            return $this->video_url;
        }

        // Raw Vimeo numeric ID or URL (e.g. vimeo.com/827340947 or 827340947)
        if (preg_match('/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)?(\d+)/', $this->video_url, $matches)) {
            return 'https://player.vimeo.com/video/'.$matches[1];
        }

        // YouTube URL
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return $this->video_url;
    }

    public function getRenderedBodyAttribute(): string
    {
        return \Illuminate\Support\Str::markdown($this->body ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }
}
