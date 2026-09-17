<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
        $imageMax = (int) config('project.upload_limits.image_max_kb', 2048);
        $mimes = implode(',', config('project.upload_limits.allowed_image_mimes', ['jpg', 'jpeg', 'png', 'webp']));
        $project = $this->route('project');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('projects', 'slug')->ignore($project),
            ],
            'summary' => ['required', 'string', 'max:2000'],
            'body' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:'.$mimes, 'max:'.$imageMax],
            'project_url' => ['nullable', 'string', 'max:255'],
            'repo_url' => ['nullable', 'string', 'max:255'],
            'video_url' => ['nullable', 'string', 'max:255'],
            'tech_stack' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }
}
