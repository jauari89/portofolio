<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SupervisionRequest;
use App\Models\Supervision;
use Illuminate\Http\RedirectResponse;

class SupervisionController extends BaseCrudController
{
    protected string $model = Supervision::class;

    protected string $routeName = 'admin.supervisions';

    protected string $title = 'Student Supervisions';

    protected string $description = 'Data mahasiswa bimbingan, judul proyek, tahun akademik, dan status penyelesaian.';

    protected string $searchColumn = 'student_name';

    protected array $indexColumns = [
        'student_name' => 'Student',
        'project_title' => 'Project Title',
        'academic_year' => 'Academic Year',
        'type' => 'Type',
        'status' => 'Status',
        'is_active' => 'Active',
    ];

    protected array $fields = [
        ['name' => 'student_name', 'label' => 'Student Name', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'student_identifier', 'label' => 'Student ID / NRP', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'academic_year', 'label' => 'Academic Year', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'project_title', 'label' => 'Project / Thesis Title', 'type' => 'text', 'col' => 'col-12'],
        ['name' => 'program', 'label' => 'Program / Major', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'options' => ['final_project' => 'Final Project', 'thesis' => 'Thesis', 'internship' => 'Internship', 'research' => 'Research', 'competition' => 'Competition'], 'col' => 'col-md-4'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['ongoing' => 'Ongoing', 'completed' => 'Completed'], 'col' => 'col-md-4'],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 5, 'col' => 'col-12'],
        ['name' => 'result_url', 'label' => 'Result / Publication URL', 'type' => 'url', 'col' => 'col-md-4'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-4'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-4'],
    ];

    public function store(SupervisionRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(SupervisionRequest $request, int|string $supervision): RedirectResponse
    {
        return $this->updateResource($request, $supervision);
    }
}
