<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StatRequest;
use App\Models\Stat;
use Illuminate\Http\RedirectResponse;

class StatController extends BaseCrudController
{
    protected string $model = Stat::class;

    protected string $routeName = 'admin.stats';

    protected string $title = 'Stats';

    protected string $description = 'Angka ringkas untuk About section.';

    protected string $searchColumn = 'label';

    protected array $indexColumns = ['label' => 'Label', 'value' => 'Value', 'sort_order' => 'Order', 'is_active' => 'Active'];

    protected array $fields = [
        ['name' => 'label', 'label' => 'Label', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'value', 'label' => 'Value', 'type' => 'number', 'col' => 'col-md-3'],
        ['name' => 'icon', 'label' => 'Icon Class', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-6'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-6'],
    ];

    public function store(StatRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(StatRequest $request, int|string $stat): RedirectResponse
    {
        return $this->updateResource($request, $stat);
    }
}
