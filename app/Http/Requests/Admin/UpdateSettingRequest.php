<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
        return [
            'site_name' => ['required', 'string', 'max:120'],
            'site_title' => ['required', 'string', 'max:200'],
            'hero_title' => ['required', 'string', 'max:160'],
            'hero_subtitle' => ['required', 'string', 'max:500'],
            'about_bio' => ['nullable', 'string', 'max:3000'],
            'contact_email' => ['required', 'email', 'max:160'],
            'contact_phone' => ['nullable', 'string', 'max:60'],
            'contact_location' => ['nullable', 'string', 'max:120'],
            'freelance_status' => ['nullable', 'string', 'max:100'],
            'birthday' => ['nullable', 'string', 'max:50'],
            'education' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'meta_author' => ['nullable', 'string', 'max:120'],
            'twitter_handle' => ['nullable', 'string', 'max:80'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'robots_indexing' => ['nullable', 'in:0,1'],
        ];
    }
}
