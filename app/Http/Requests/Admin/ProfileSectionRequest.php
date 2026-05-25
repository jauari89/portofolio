<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:180'],
            'professional_title' => ['required', 'string', 'max:220'],
            'short_description' => ['required', 'string', 'max:500'],
            'long_description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:180'],
            'primary_email' => ['nullable', 'email', 'max:150'],
            'secondary_email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:40'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'birthdate' => ['nullable', 'date'],
        ];
    }
}
