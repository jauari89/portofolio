<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeachingCourseMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    public function rules(): array
    {
        $materialId = $this->route('teaching_material');

        return [
            'teaching_course_id' => ['required', 'integer', Rule::exists('teaching_courses', 'id')],
            'week_number' => [
                'required',
                'integer',
                'min:1',
                'max:16',
                Rule::unique('teaching_course_materials', 'week_number')
                    ->where('teaching_course_id', $this->input('teaching_course_id'))
                    ->ignore($materialId),
            ],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:3000'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'material_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
