<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PublicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    public function rules(): array
    {
        return [
            'authors' => ['required', 'string', 'max:1000'],
            'title' => ['required', 'string', 'max:500'],
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'publisher' => ['nullable', 'string', 'max:180'],
            'journal_or_conference' => ['nullable', 'string', 'max:220'],
            'doi' => ['nullable', 'string', 'max:120'],
            'url' => ['nullable', 'url', 'max:255'],
            'abstract' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
