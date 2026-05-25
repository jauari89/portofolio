@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">{{ $title }}</h1>
        <p class="text-muted mb-0">{{ $description }}</p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary align-self-md-center" rel="noopener"><i class="bi bi-box-arrow-up-right me-1"></i>Preview</a>
</div>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card card-clean">
    @csrf
    @method('PUT')
    <div class="card-header bg-white">
        <strong>{{ $title }} Form</strong>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($fields as $field)
                @include('admin.crud._field', ['field' => $field, 'item' => $item])
            @endforeach
        </div>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <button class="btn btn-primary" type="submit"><i class="bi bi-check2 me-1"></i>Save Changes</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
    </div>
</form>
@endsection
