<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;

class PortfolioController extends BaseCrudController
{
    protected string $model = Portfolio::class;

    protected string $routeName = 'admin.portfolios';

    protected string $title = 'Portfolios';

    protected string $description = 'Karya, sistem, riset terapan, dan project mahasiswa.';

    protected string $searchColumn = 'title';

    protected array $fileFields = ['thumbnail' => 'portfolios'];

    protected array $indexColumns = ['title' => 'Title', 'category' => 'Category', 'year' => 'Year', 'status' => 'Status', 'sort_order' => 'Order'];

    protected array $fields = [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'category', 'label' => 'Category', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'year', 'label' => 'Year', 'type' => 'number', 'col' => 'col-md-2'],
        ['name' => 'client_or_institution', 'label' => 'Client / Institution', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'short_description', 'label' => 'Short Description', 'type' => 'textarea', 'rows' => 3, 'col' => 'col-12'],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'rows' => 8, 'col' => 'col-12'],
        ['name' => 'thumbnail', 'label' => 'Thumbnail', 'type' => 'file', 'accept' => 'image/*', 'col' => 'col-md-4'],
        ['name' => 'demo_url', 'label' => 'Demo URL', 'type' => 'url', 'col' => 'col-md-4'],
        ['name' => 'repository_url', 'label' => 'Repository URL', 'type' => 'url', 'col' => 'col-md-4'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['draft' => 'Draft', 'published' => 'Published'], 'col' => 'col-md-6'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-6'],
    ];

    public function store(PortfolioRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(PortfolioRequest $request, int|string $portfolio): RedirectResponse
    {
        return $this->updateResource($request, $portfolio);
    }
}
