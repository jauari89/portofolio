<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SkillRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;

class SkillController extends BaseCrudController
{
    protected string $model = Skill::class;

    protected string $routeName = 'admin.skills';

    protected string $title = 'Skills';

    protected string $description = 'Skill teknis dan level persentase untuk progress bar.';

    protected string $searchColumn = 'name';

    protected array $indexColumns = ['name' => 'Skill', 'category' => 'Category', 'percentage' => 'Level', 'sort_order' => 'Order', 'is_active' => 'Active'];

    protected array $fields = [
        ['name' => 'name', 'label' => 'Skill Name', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'category', 'label' => 'Category', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'percentage', 'label' => 'Percentage', 'type' => 'number', 'col' => 'col-md-4'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-4'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-4'],
    ];

    public function store(SkillRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(SkillRequest $request, int|string $skill): RedirectResponse
    {
        return $this->updateResource($request, $skill);
    }
}
