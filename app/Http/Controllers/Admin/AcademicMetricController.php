<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AcademicMetricRequest;
use App\Models\AcademicMetric;
use Illuminate\Http\RedirectResponse;

class AcademicMetricController extends BaseCrudController
{
    protected string $model = AcademicMetric::class;

    protected string $routeName = 'admin.academic-metrics';

    protected string $title = 'Academic Metrics';

    protected string $description = 'Profil dan metrik akademik dari SINTA, Google Scholar, Scopus, ORCID, atau sumber resmi lain.';

    protected string $searchColumn = 'label';

    protected array $indexColumns = [
        'label' => 'Label',
        'value' => 'Value',
        'source_name' => 'Source',
        'sort_order' => 'Order',
        'is_active' => 'Active',
    ];

    protected array $searchColumns = [
        'label' => 'Label',
        'value' => 'Value',
        'source_name' => 'Source',
    ];

    protected array $fields = [
        ['name' => 'label', 'label' => 'Label', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'value', 'label' => 'Value', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'suffix', 'label' => 'Suffix', 'type' => 'text', 'col' => 'col-md-2'],
        ['name' => 'icon', 'label' => 'Bootstrap Icon Class', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'source_name', 'label' => 'Source Name', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'source_url', 'label' => 'Source URL', 'type' => 'url', 'col' => 'col-md-8'],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3, 'col' => 'col-12'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-6'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-6'],
    ];

    public function store(AcademicMetricRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(AcademicMetricRequest $request, int|string $academicMetric): RedirectResponse
    {
        return $this->updateResource($request, $academicMetric);
    }
}
