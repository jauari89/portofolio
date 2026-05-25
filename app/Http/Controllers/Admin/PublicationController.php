<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PublicationRequest;
use App\Models\Publication;
use Illuminate\Http\RedirectResponse;

class PublicationController extends BaseCrudController
{
    protected string $model = Publication::class;

    protected string $routeName = 'admin.publications';

    protected string $title = 'Publications';

    protected string $description = 'Publikasi akademik, prosiding, jurnal, DOI, dan tautan eksternal.';

    protected string $searchColumn = 'title';

    protected array $indexColumns = ['title' => 'Title', 'authors' => 'Authors', 'year' => 'Year', 'journal_or_conference' => 'Journal / Conference', 'is_active' => 'Active'];

    protected array $fields = [
        ['name' => 'authors', 'label' => 'Authors', 'type' => 'textarea', 'rows' => 3, 'col' => 'col-12'],
        ['name' => 'title', 'label' => 'Title', 'type' => 'textarea', 'rows' => 3, 'col' => 'col-12'],
        ['name' => 'year', 'label' => 'Year', 'type' => 'number', 'col' => 'col-md-3'],
        ['name' => 'publisher', 'label' => 'Publisher', 'type' => 'text', 'col' => 'col-md-3'],
        ['name' => 'journal_or_conference', 'label' => 'Journal / Conference', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'doi', 'label' => 'DOI', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'url', 'label' => 'URL', 'type' => 'url', 'col' => 'col-md-4'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'col' => 'col-md-2'],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'col' => 'col-md-2'],
        ['name' => 'abstract', 'label' => 'Abstract', 'type' => 'textarea', 'rows' => 6, 'col' => 'col-12'],
    ];

    public function store(PublicationRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(PublicationRequest $request, int|string $publication): RedirectResponse
    {
        return $this->updateResource($request, $publication);
    }
}
