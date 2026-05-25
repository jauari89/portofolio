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
        <form method="GET" class="row g-2">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari data...">
                </div>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-outline-primary">Search</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    @foreach($columns as $label)
                        <th>{{ $label }}</th>
                    @endforeach
                    <th class="text-end" style="width:210px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
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
                        <td colspan="{{ count($columns) + 1 }}" class="text-center text-muted py-5">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
        <div class="card-body border-top">{{ $items->links() }}</div>
    @endif
</div>
@endsection
