<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;

class BlogPostController extends BaseCrudController
{
    protected string $model = BlogPost::class;

    protected string $routeName = 'admin.blog';

    protected string $title = 'Blog Posts';

    protected string $description = 'Artikel terbaru, kategori, thumbnail, dan status publish.';

    protected string $orderColumn = '';

    protected string $searchColumn = 'title';

    protected array $fileFields = ['thumbnail' => 'blog'];

    protected array $indexColumns = ['title' => 'Title', 'category' => 'Category', 'published_at' => 'Published At', 'status' => 'Status'];

    protected array $fields = [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 'col-md-6'],
        ['name' => 'category', 'label' => 'Category', 'type' => 'text', 'col' => 'col-md-4'],
        ['name' => 'published_at', 'label' => 'Published At', 'type' => 'datetime-local', 'col' => 'col-md-4'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['draft' => 'Draft', 'published' => 'Published'], 'col' => 'col-md-4'],
        ['name' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea', 'rows' => 3, 'col' => 'col-12'],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'rows' => 10, 'col' => 'col-12'],
        ['name' => 'thumbnail', 'label' => 'Thumbnail', 'type' => 'file', 'accept' => 'image/*', 'col' => 'col-md-6'],
    ];

    public function store(BlogPostRequest $request): RedirectResponse
    {
        return $this->storeResource($request);
    }

    public function update(BlogPostRequest $request, int|string $blog): RedirectResponse
    {
        return $this->updateResource($request, $blog);
    }
}
