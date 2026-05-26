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
use Illuminate\Support\Str;
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

    protected array $searchColumns = [];

    protected array $sortableColumns = [];

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
            'searchColumns' => $this->searchableColumns(),
            'selectedSearchColumn' => $this->selectedSearchColumn($request),
            'autocompleteOptions' => $this->autocompleteOptions(),
            'sortableColumns' => array_keys($this->sortableColumns()),
            'currentSort' => $this->currentSortColumn($request),
            'currentDirection' => $this->currentSortDirection($request),
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
        $query = $this->model::query();
        $keyword = trim($request->string('q')->toString());
        $searchColumn = $this->selectedSearchColumn($request);
        $searchColumns = array_keys($this->searchableColumns());

        if ($keyword !== '' && $searchColumns !== []) {
            $query->where(function ($searchQuery) use ($keyword, $searchColumn, $searchColumns) {
                if ($searchColumn) {
                    $searchQuery->where($searchColumn, 'like', '%'.$keyword.'%');

                    return;
                }

                foreach ($searchColumns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $searchQuery->{$method}($column, 'like', '%'.$keyword.'%');
                }
            });
        }

        if ($sortColumn = $this->currentSortColumn($request)) {
            $query->orderBy($sortColumn, $this->currentSortDirection($request));
        } elseif ($this->orderColumn) {
            $query->orderBy($this->orderColumn);
        }

        return $query
            ->latest('id')
            ->paginate($this->perPage)
            ->withQueryString();
    }

    protected function searchableColumns(): array
    {
        if ($this->searchColumns !== []) {
            return $this->searchColumns;
        }

        $columns = [];

        if ($this->searchColumn !== '') {
            $columns[$this->searchColumn] = $this->indexColumns[$this->searchColumn] ?? Str::headline($this->searchColumn);
        }

        foreach ($this->indexColumns as $column => $label) {
            if (in_array($column, ['is_active', 'sort_order'], true)) {
                continue;
            }

            $columns[$column] = $label;
        }

        return $columns;
    }

    protected function sortableColumns(): array
    {
        return $this->sortableColumns !== [] ? $this->sortableColumns : $this->indexColumns;
    }

    protected function selectedSearchColumn(Request $request): string
    {
        $column = $request->string('search_by')->toString();

        return array_key_exists($column, $this->searchableColumns()) ? $column : '';
    }

    protected function currentSortColumn(Request $request): string
    {
        $column = $request->string('sort')->toString();

        return array_key_exists($column, $this->sortableColumns()) ? $column : '';
    }

    protected function currentSortDirection(Request $request): string
    {
        return $request->string('direction')->lower()->toString() === 'desc' ? 'desc' : 'asc';
    }

    protected function autocompleteOptions(): array
    {
        $options = [];

        foreach ($this->searchableColumns() as $column => $label) {
            $options[$column] = $this->model::query()
                ->whereNotNull($column)
                ->where($column, '!=', '')
                ->distinct()
                ->orderBy($column)
                ->limit(80)
                ->pluck($column)
                ->map(fn ($value) => (string) $value)
                ->filter()
                ->values()
                ->all();
        }

        $options['_all'] = collect($options)
            ->flatten()
            ->unique()
            ->take(80)
            ->values()
            ->all();

        return $options;
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
