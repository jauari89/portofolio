@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">{{ $title }}</h1>
        <p class="text-muted mb-0">{{ $description }}</p>
    </div>
    <a href="{{ route($routeName.'.create') }}" class="btn btn-primary align-self-lg-center"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>

<div class="card card-clean">
    <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between gap-3">
        <div>
            <strong>Data {{ $title }}</strong>
            <div class="small text-muted">Kelola status, urutan, dan konten yang tampil di website.</div>
        </div>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2 align-items-end" data-admin-search>
            @if($currentSort)
                <input type="hidden" name="sort" value="{{ $currentSort }}">
                <input type="hidden" name="direction" value="{{ $currentDirection }}">
            @endif
            <div class="col-lg-6">
                <label class="form-label small text-muted mb-1" for="admin-search-query">Keyword</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input id="admin-search-query" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari data..." list="admin-search-suggestions" autocomplete="off" data-autocomplete-input>
                </div>
                <datalist id="admin-search-suggestions"></datalist>
            </div>
            <div class="col-lg-3 col-md-5">
                <label class="form-label small text-muted mb-1" for="admin-search-field">Field</label>
                <select id="admin-search-field" name="search_by" class="form-select" data-autocomplete-field>
                    <option value="" @selected($selectedSearchColumn === '')>All fields</option>
                    @foreach($searchColumns as $column => $label)
                        <option value="{{ $column }}" @selected($selectedSearchColumn === $column)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-4 d-grid">
                <button class="btn btn-outline-primary">Search</button>
            </div>
            <div class="col-lg-1 col-md-3 d-grid">
                <a href="{{ route($routeName.'.index') }}" class="btn btn-outline-secondary" title="Reset filter"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:72px;">#</th>
                    @foreach($columns as $column => $label)
                        @php
                            $isSortable = in_array($column, $sortableColumns, true);
                            $isActiveSort = $currentSort === $column;
                            $nextDirection = $isActiveSort && $currentDirection === 'asc' ? 'desc' : 'asc';
                            $sortUrl = route($routeName.'.index', array_merge(request()->except(['page', 'sort', 'direction']), [
                                'sort' => $column,
                                'direction' => $nextDirection,
                            ]));
                        @endphp
                        <th>
                            @if($isSortable)
                                <a href="{{ $sortUrl }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-reset">
                                    <span>{{ $label }}</span>
                                    @if($isActiveSort)
                                        <i class="bi bi-arrow-{{ $currentDirection === 'asc' ? 'up' : 'down' }} text-primary"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    @endif
                                </a>
                            @else
                                {{ $label }}
                            @endif
                        </th>
                    @endforeach
                    <th class="text-end" style="width:210px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="text-muted fw-semibold">{{ $items->firstItem() + $loop->index }}</td>
                        @foreach($columns as $column => $label)
                            @php $value = $item->{$column}; @endphp
                            <td>
                                @if(is_bool($value))
                                    <span class="badge text-bg-{{ $value ? 'success' : 'secondary' }}">{{ $value ? 'Yes' : 'No' }}</span>
                                @elseif($column === 'status')
                                    <span class="badge text-bg-{{ $value === 'published' ? 'success' : ($value === 'unread' ? 'danger' : 'secondary') }}">{{ $value }}</span>
                                @elseif(is_object($value) && method_exists($value, 'format'))
                                    {{ $value->format('d M Y H:i') }}
                                @else
                                    {{ \Illuminate\Support\Str::limit((string) $value, 70) }}
                                @endif
                            </td>
                        @endforeach
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route($routeName.'.show', $item->getKey()) }}" class="btn btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route($routeName.'.edit', $item->getKey()) }}" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route($routeName.'.destroy', $item->getKey()) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger rounded-start-0" type="submit" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 2 }}" class="text-center text-muted py-5">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
        <div class="card-body border-top">{{ $items->links() }}</div>
    @endif
</div>

<script>
    (() => {
        const form = document.querySelector('[data-admin-search]');

        if (!form) {
            return;
        }

        const field = form.querySelector('[data-autocomplete-field]');
        const list = form.querySelector('#admin-search-suggestions');
        const options = @json($autocompleteOptions);

        const refreshOptions = () => {
            const values = options[field.value] || options._all || [];

            list.replaceChildren(...values.map((value) => {
                const option = document.createElement('option');
                option.value = value;

                return option;
            }));
        };

        field.addEventListener('change', refreshOptions);
        refreshOptions();
    })();
</script>
@endsection
