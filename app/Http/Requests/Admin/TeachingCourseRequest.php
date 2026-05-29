<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeachingCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    public function rules(): array
    {
        return [
            'course_name' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200'],
            'course_code' => ['nullable', 'string', 'max:60'],
            'semester' => ['nullable', 'string', 'max:80'],
            'academic_year' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:2000'],
            'overview' => ['nullable', 'string', 'max:8000'],
            'material_url' => ['nullable', 'url', 'max:255'],
            'materials' => ['nullable', 'string', 'max:12000'],
            'rps_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'rps_url' => ['nullable', 'url', 'max:255'],
            'rps_summary' => ['nullable', 'string', 'max:8000'],
            'sample_projects' => ['nullable', 'string', 'max:12000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
