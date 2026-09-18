<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeRequest extends FormRequest
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
        $maxKb = (int) config('project.upload_limits.pdf_max_kb', 5120);

        return [
            'title' => ['required', 'string', 'max:160'],
            'resume_file' => ['nullable', 'file', 'mimes:pdf', "max:{$maxKb}"],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
