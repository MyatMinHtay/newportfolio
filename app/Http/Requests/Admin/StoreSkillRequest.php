<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
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

        return [
            'name' => ['required', 'string', 'max:120', 'unique:skills,name'],
            'category' => ['required', 'string', 'max:80'],
            'icon' => ['nullable', 'image', 'mimes:'.$mimes, 'max:'.$imageMax],
            'proficiency' => ['nullable', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }
}
