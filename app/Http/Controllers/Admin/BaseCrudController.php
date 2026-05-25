<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

abstract class BaseCrudController extends Controller
{
    use HandlesUploads;

    protected string $model;

    protected string $routeName;

    protected string $title;

    protected string $description = '';

    protected string $orderColumn = 'sort_order';

    protected string $searchColumn = 'title';

    protected int $perPage = 12;

    protected array $fields = [];

    protected array $fileFields = [];

    protected array $indexColumns = [];

    public function index(Request $request): View
    {
        return view('admin.crud.index', [
            'title' => $this->title,
            'description' => $this->description,
            'routeName' => $this->routeName,
            'columns' => $this->indexColumns,
            'items' => $this->paginate($request),
        ]);
    }

    public function create(): View
    {
        return view('admin.crud.form', [
            'title' => 'Tambah '.$this->title,
            'routeName' => $this->routeName,
            'fields' => $this->fields,
            'item' => new $this->model,
            'method' => 'POST',
            'action' => route($this->routeName.'.store'),
        ]);
    }

    public function show(int|string $id): View
    {
        return view('admin.crud.show', [
            'title' => 'Detail '.$this->title,
            'routeName' => $this->routeName,
            'fields' => $this->fields,
            'item' => $this->findItem($id),
        ]);
    }

    public function edit(int|string $id): View
    {
        return view('admin.crud.form', [
            'title' => 'Edit '.$this->title,
            'routeName' => $this->routeName,
            'fields' => $this->fields,
            'item' => $this->findItem($id),
            'method' => 'PUT',
            'action' => route($this->routeName.'.update', $id),
        ]);
    }

    public function destroy(int|string $id): RedirectResponse
    {
        $item = $this->findItem($id);
        $item->delete();

        return redirect()
            ->route($this->routeName.'.index')
            ->with('success', $this->title.' berhasil dihapus.');
    }

    protected function storeResource(FormRequest $request): RedirectResponse
    {
        $data = $this->prepareData($request);
        $this->model::query()->create($data);

        return redirect()
            ->route($this->routeName.'.index')
            ->with('success', $this->title.' berhasil ditambahkan.');
    }

    protected function updateResource(FormRequest $request, int|string $id): RedirectResponse
    {
        $item = $this->findItem($id);
        $data = $this->prepareData($request, $item);
        $item->update($data);

        return redirect()
            ->route($this->routeName.'.index')
            ->with('success', $this->title.' berhasil diperbarui.');
    }

    protected function paginate(Request $request): LengthAwarePaginator
    {
        return $this->model::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where($this->searchColumn, 'like', '%'.$request->string('q')->toString().'%');
            })
            ->when($this->orderColumn, fn ($query) => $query->orderBy($this->orderColumn))
            ->latest('id')
            ->paginate($this->perPage)
            ->withQueryString();
    }

    protected function findItem(int|string $id): Model
    {
        return $this->model::query()->findOrFail($id);
    }

    protected function prepareData(FormRequest $request, ?Model $item = null): array
    {
        $data = $request->validated();

        foreach ($this->fields as $field) {
            if (($field['type'] ?? null) === 'checkbox') {
                $data[$field['name']] = $request->boolean($field['name']);
            }
        }

        foreach ($this->fileFields as $field => $directory) {
            $stored = $this->storeUpload($request, $field, $directory, $item?->{$field});

            if ($stored) {
                $data[$field] = $stored;
            } else {
                unset($data[$field]);
            }
        }

        return $data;
    }

    protected function deleteStoredFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
