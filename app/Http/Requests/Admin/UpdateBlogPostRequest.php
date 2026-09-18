<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $maxKb = (int) config('project.upload_limits.image_max_kb', 2048);

        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                Rule::unique('blog_posts', 'slug')->ignore($this->route('post')),
            ],
            'category_id' => ['nullable', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', "max:{$maxKb}"],
            'is_published' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
