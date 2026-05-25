<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupervisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:180'],
            'student_identifier' => ['nullable', 'string', 'max:80'],
            'project_title' => ['required', 'string', 'max:220'],
            'program' => ['nullable', 'string', 'max:120'],
            'academic_year' => ['nullable', 'string', 'max:40'],
            'type' => ['required', Rule::in(['final_project', 'thesis', 'internship', 'research', 'competition'])],
            'status' => ['required', Rule::in(['ongoing', 'completed'])],
            'description' => ['nullable', 'string', 'max:2000'],
            'result_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
