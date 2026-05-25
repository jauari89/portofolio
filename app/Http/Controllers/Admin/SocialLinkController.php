<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SocialLinkRequest;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;

class SocialLinkController extends BaseCrudController
{
    protected string $model = SocialLink::class;

    protected string $routeName = 'admin.social-links';

    protected string $title = 'Social Links';

    protected string $description = 'Tautan media sosial dan platform profesional.';

    protected string $searchColumn = 'platform';

    protected array $indexColumns = ['platform' => 'Platform', 'url' => 'URL', 'icon' => 'Icon', 'sort_order' => 'Order', 'is_active' => 'Active'];

    protected array $fields = [
        ['name' => 'platform', 'label' => 'Platform', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'url', 'label' => 'URL', 'type' => 'url', 'col' => 'col-md-4'],
        ['name' => 'icon', 'label' => 'Bootstrap Icon Class', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-6'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-6'],
    ];

    public function store(SocialLinkRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(SocialLinkRequest $request, int|string $social_link): RedirectResponse
    {
        return $this->updateResource($request, $social_link);
    }
}
