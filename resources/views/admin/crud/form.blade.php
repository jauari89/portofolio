@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">{{ $title }}</h1>
        <p class="text-muted mb-0">Isi data dengan lengkap lalu simpan perubahan.</p>
    </div>
    <a href="{{ route($routeName.'.index') }}" class="btn btn-outline-secondary align-self-md-center"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card card-clean">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    <div class="card-header bg-white">
        <strong>Form {{ $title }}</strong>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($fields as $field)
                @include('admin.crud._field', ['field' => $field, 'item' => $item])
            @endforeach
        </div>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <button class="btn btn-primary" type="submit"><i class="bi bi-check2 me-1"></i>Save</button>
        <a href="{{ route($routeName.'.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection
