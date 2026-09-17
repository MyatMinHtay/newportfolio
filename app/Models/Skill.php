<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'icon_path',
        'proficiency',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
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
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function getIconUrlAttribute(): string
    {
        if ($this->icon_path) {
            if (str_starts_with($this->icon_path, 'http://') || str_starts_with($this->icon_path, 'https://')) {
                return $this->icon_path;
            }

            if (str_starts_with($this->icon_path, 'assets/')) {
                return asset($this->icon_path);
            }

            return Storage::disk('public')->url($this->icon_path);
        }

        $map = [
            'html5' => 'html.png',
            'html' => 'html.png',
            'css3' => 'css.png',
            'css' => 'css.png',
            'bootstrap 5' => 'bootstrap.png',
            'bootstrap' => 'bootstrap.png',
            'javascript' => 'js.png',
            'javascript (es6+)' => 'js.png',
            'js' => 'js.png',
            'jquery' => 'jquery.png',
            'vue.js' => 'vue.png',
            'vue' => 'vue.png',
            'angular' => 'angular.png',
            'react' => 'react.png',
            'php' => 'php.png',
            'laravel' => 'laravel.png',
            'node.js' => 'nodejs.png',
            'nodejs' => 'nodejs.png',
            'python' => 'python.png',
            'wordpress' => 'wordpress.png',
            'mysql' => 'mysql.png',
            'mongodb' => 'mongodb.png',
            'git / github' => 'github.png',
            'git' => 'github.png',
            'github' => 'github.png',
            'aws s3' => 'skill.png',
            'docker' => 'skill.png',
            'telegram bots' => 'skill.png',
            'laravel socialite' => 'laravel.png',
            'socialite' => 'laravel.png',
            'linux basic' => 'skill.png',
            'linux' => 'skill.png',
        ];

        $key = strtolower(trim($this->name));
        $file = $map[$key] ?? 'skill.png';

        return asset('assets/img/skills/'.$file);
    }
}
