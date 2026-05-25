<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;

class ExperienceController extends BaseCrudController
{
    protected string $model = Experience::class;

    protected string $routeName = 'admin.experiences';

    protected string $title = 'Education & Experience';

    protected string $description = 'Timeline pendidikan, pekerjaan, organisasi, dan sertifikasi.';

    protected string $searchColumn = 'title';

    protected array $indexColumns = ['type' => 'Type', 'title' => 'Title', 'institution' => 'Institution', 'start_year' => 'Start', 'end_year' => 'End', 'is_active' => 'Active'];

    protected array $fields = [
        ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'options' => ['education' => 'Education', 'work' => 'Work', 'organization' => 'Organization', 'certification' => 'Certification'], 'col' => 'col-md-4'],
        ['name' => 'title', 'label' => 'Title / Program', 'type' => 'text', 'col' => 'col-md-8'],
        ['name' => 'institution', 'label' => 'Institution', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'location', 'label' => 'Location', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'start_year', 'label' => 'Start Year', 'type' => 'number', 'col' => 'col-md-3'],
        ['name' => 'end_year', 'label' => 'End Year', 'type' => 'number', 'col' => 'col-md-3'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-3'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-3'],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 5, 'col' => 'col-12'],
    ];

    public function store(ExperienceRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(ExperienceRequest $request, int|string $experience): RedirectResponse
    {
        return $this->updateResource($request, $experience);
    }
}
