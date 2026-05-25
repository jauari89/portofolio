@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">{{ $title }}</h1>
        <p class="text-muted mb-0">Preview data sebelum dipublikasikan.</p>
    </div>
    <div class="d-flex gap-2 align-self-md-center">
        <a href="{{ route($routeName.'.edit', $item->getKey()) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route($routeName.'.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
    </div>
</div>

<div class="card card-clean">
    <div class="card-header bg-white"><strong>Preview</strong></div>
    <div class="card-body">
        <div class="row g-4">
            @foreach($fields as $field)
                @php
                    $name = $field['name'];
                    $value = $item->{$name};
                @endphp
                <div class="{{ $field['col'] ?? 'col-12' }}">
                    <div class="text-muted small fw-semibold">{{ $field['label'] ?? str($name)->headline() }}</div>
                    @if(($field['type'] ?? null) === 'file' && $value)
                        <a href="{{ asset('storage/'.$value) }}" target="_blank" rel="noopener">{{ basename($value) }}</a>
                    @elseif(is_bool($value))
                        <span class="badge text-bg-{{ $value ? 'success' : 'secondary' }}">{{ $value ? 'Yes' : 'No' }}</span>
                    @elseif(is_object($value) && method_exists($value, 'format'))
                        <div>{{ $value->format('d M Y H:i') }}</div>
                    @else
                        <div>{!! nl2br(e($value ?: '-')) !!}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
