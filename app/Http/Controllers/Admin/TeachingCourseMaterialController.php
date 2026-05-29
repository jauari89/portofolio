<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TeachingCourseMaterialRequest;
use App\Models\TeachingCourse;
use App\Models\TeachingCourseMaterial;
use Illuminate\Http\RedirectResponse;

class TeachingCourseMaterialController extends BaseCrudController
{
    protected string $model = TeachingCourseMaterial::class;

    protected string $routeName = 'admin.teaching-materials';

    protected string $title = 'Teaching Materials';

    protected string $description = 'Materi pembelajaran mingguan, PDF, dan tautan materi untuk halaman mata kuliah.';

    protected string $searchColumn = 'title';

    protected array $searchColumns = [
        'title' => 'Title',
        'week_number' => 'Week',
        'description' => 'Description',
    ];

    protected array $sortableColumns = [
        'week_number' => 'Week',
        'title' => 'Title',
        'sort_order' => 'Sort Order',
        'is_active' => 'Active',
    ];

    protected array $indexColumns = [
        'course_label' => 'Course',
        'week_number' => 'Week',
        'title' => 'Title',
        'has_pdf' => 'PDF',
        'is_active' => 'Active',
    ];

    protected array $fileFields = [
        'pdf_file' => 'teaching/materials',
    ];

    public function __construct()
    {
        $this->fields = [
            ['name' => 'teaching_course_id', 'label' => 'Course', 'type' => 'select', 'options' => $this->courseOptions(), 'col' => 'col-md-6'],
            ['name' => 'week_number', 'label' => 'Week Number (1-16)', 'type' => 'number', 'col' => 'col-md-3'],
            ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-3'],
            ['name' => 'title', 'label' => 'Material Title', 'type' => 'text', 'col' => 'col-md-6'],
            ['name' => 'material_url', 'label' => 'External PDF URL', 'type' => 'url', 'col' => 'col-md-6'],
            ['name' => 'pdf_file', 'label' => 'PDF File', 'type' => 'file', 'accept' => 'application/pdf,.pdf', 'col' => 'col-md-6'],
            ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-2'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 5, 'col' => 'col-12'],
        ];
    }

    public function store(TeachingCourseMaterialRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(TeachingCourseMaterialRequest $request, int|string $teachingMaterial): RedirectResponse
    {
        return $this->updateResource($request, $teachingMaterial);
    }

    private function courseOptions(): array
    {
        return TeachingCourse::query()
            ->ordered()
            ->pluck('course_name', 'id')
            ->all();
    }
}
