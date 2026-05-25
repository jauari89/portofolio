@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $icons = [
        'Portfolio' => 'bi bi-kanban',
        'Published Portfolio' => 'bi bi-check-circle',
        'Publications' => 'bi bi-journal-text',
        'Teaching Courses' => 'bi bi-easel',
        'Supervisions' => 'bi bi-people',
        'Blog Posts' => 'bi bi-pencil-square',
        'Unread Messages' => 'bi bi-envelope',
    ];
@endphp

<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Ringkasan konten portfolio dan pesan masuk.</p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-primary align-self-md-center" rel="noopener">
        <i class="bi bi-box-arrow-up-right me-1"></i>Preview Website
    </a>
</div>

<div class="row g-3 mb-4">
    @foreach($counts as $label => $value)
        <div class="col-md-4 col-xl-2">
            <div class="card card-clean h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="text-muted small">{{ $label }}</div>
                            <div class="h3 fw-bold mb-0">{{ $value }}</div>
                        </div>
                        <span class="badge text-bg-primary rounded-pill p-2">
                            <i class="{{ $icons[$label] ?? 'bi bi-grid' }}"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-clean">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h6 fw-bold mb-0">Latest Messages</h2>
                <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-outline-secondary">View all</a>
            </div>
            <div class="list-group list-group-flush p-3">
                @forelse($latestMessages as $message)
                    <a href="{{ route('admin.contact-messages.show', $message) }}" class="list-group-item list-group-item-action px-0">
                        <div class="d-flex justify-content-between gap-3">
                            <strong>{{ $message->subject }}</strong>
                            <span class="badge text-bg-{{ $message->status === 'unread' ? 'danger' : 'secondary' }}">{{ $message->status }}</span>
                        </div>
                        <div class="small text-muted">{{ $message->name }} - {{ $message->created_at->diffForHumans() }}</div>
                    </a>
                @empty
                    <div class="text-muted py-3">Belum ada pesan.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-clean">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h6 fw-bold mb-0">Latest Blog Posts</h2>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-outline-secondary">Manage</a>
            </div>
            <div class="list-group list-group-flush p-3">
                @forelse($latestPosts as $post)
                    <a href="{{ route('admin.blog.edit', $post->getKey()) }}" class="list-group-item list-group-item-action px-0">
                        <div class="d-flex justify-content-between gap-3">
                            <strong>{{ $post->title }}</strong>
                            <span class="badge text-bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">{{ $post->status }}</span>
                        </div>
                        <div class="small text-muted">{{ $post->category ?: 'Uncategorized' }}</div>
                    </a>
                @empty
                    <div class="text-muted py-3">Belum ada artikel.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
