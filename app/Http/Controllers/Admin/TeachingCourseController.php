<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TeachingCourseRequest;
use App\Models\TeachingCourse;
use Illuminate\Http\RedirectResponse;

class TeachingCourseController extends BaseCrudController
{
    protected string $model = TeachingCourse::class;

    protected string $routeName = 'admin.teaching';

    protected string $title = 'Teaching Courses';

    protected string $description = 'Mata kuliah, tahun akademik, dan tautan materi.';

    protected string $searchColumn = 'course_name';

    protected array $indexColumns = ['course_name' => 'Course', 'semester' => 'Semester', 'academic_year' => 'Academic Year', 'slug' => 'Slug', 'is_active' => 'Active'];

    protected array $fileFields = [
        'rps_file' => 'teaching/rps',
    ];

    protected array $fields = [
        ['name' => 'course_name', 'label' => 'Course Name', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'course_code', 'label' => 'Course Code', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'semester', 'label' => 'Semester', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'academic_year', 'label' => 'Academic Year', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'material_url', 'label' => 'Material URL', 'type' => 'url', 'col' => 'col-md-4'],
        ['name' => 'rps_url', 'label' => 'RPS URL', 'type' => 'url', 'col' => 'col-md-4'],
        ['name' => 'rps_file', 'label' => 'RPS File (PDF)', 'type' => 'file', 'accept' => 'application/pdf,.pdf', 'col' => 'col-md-4'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-2'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-2'],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 5, 'col' => 'col-12'],
        ['name' => 'overview', 'label' => 'Course Overview', 'type' => 'textarea', 'rows' => 6, 'col' => 'col-12'],
        ['name' => 'materials', 'label' => 'Materials (one item per line)', 'type' => 'textarea', 'rows' => 7, 'col' => 'col-md-6'],
        ['name' => 'rps_summary', 'label' => 'RPS Summary', 'type' => 'textarea', 'rows' => 7, 'col' => 'col-md-6'],
        ['name' => 'sample_projects', 'label' => 'Sample Projects (one item per line)', 'type' => 'textarea', 'rows' => 7, 'col' => 'col-12'],
    ];

    public function store(TeachingCourseRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(TeachingCourseRequest $request, int|string $teaching): RedirectResponse
    {
        return $this->updateResource($request, $teaching);
    }
}
