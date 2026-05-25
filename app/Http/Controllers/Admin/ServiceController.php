<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;

class ServiceController extends BaseCrudController
{
    protected string $model = Service::class;

    protected string $routeName = 'admin.services';

    protected string $title = 'Services';

    protected string $description = 'Layanan atau area keahlian yang tampil sebagai card.';

    protected string $searchColumn = 'title';

    protected array $indexColumns = ['title' => 'Title', 'icon' => 'Icon', 'sort_order' => 'Order', 'is_active' => 'Active'];

    protected array $fields = [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'icon', 'label' => 'Bootstrap Icon Class', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 5, 'col' => 'col-12'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-6'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-6'],
    ];

    public function store(ServiceRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(ServiceRequest $request, int|string $service): RedirectResponse
    {
        return $this->updateResource($request, $service);
    }
}
