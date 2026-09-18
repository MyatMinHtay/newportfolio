<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Mark this resume as active and deactivate all others in a transaction.
     */
    public function activate(): void
    {
        DB::transaction(function () {
            static::query()->where('id', '!=', $this->id)->update(['is_active' => false]);
            $this->update(['is_active' => true]);
        });
    }

    public function getFileUrlAttribute(): string
    {
        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        if (str_starts_with($this->file_path, 'assets/') || str_starts_with($this->file_path, 'storage/')) {
            return asset(ltrim($this->file_path, '/'));
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->file_path);
    }
}
