@extends('layouts.public')

@section('title', __('site.blog.title').' | '.($setting->site_name ?? 'Jauari Akhmad'))

@section('content')
<main class="section section-soft">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
            <div>
                <div class="section-kicker">{{ __('site.blog.title') }}</div>
                <h1 class="fw-bold mt-2">{{ __('site.blog.index_title') }}</h1>
            </div>
            <div class="d-flex flex-wrap gap-2 align-self-lg-end">
                <a href="{{ route('blog.index') }}" class="btn btn-sm {{ $selectedCategory ? 'btn-outline-primary' : 'btn-primary' }}">{{ __('site.common.all') }}</a>
                @foreach($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category]) }}" class="btn btn-sm {{ $selectedCategory === $category ? 'btn-primary' : 'btn-outline-primary' }}">{{ $category }}</a>
                @endforeach
            </div>
        </div>
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-6 col-xl-4">
                    <article class="card card-clean blog-card h-100 overflow-hidden">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}">
                        @else
                            <div class="media-placeholder">{{ $post->category ?: __('site.common.article') }}</div>
                        @endif
                        <div class="card-body">
                            <div class="text-muted small mb-2">{{ $post->published_at?->format('d M Y') }} &middot; {{ $post->category }}</div>
                            <h2 class="h5 fw-bold">{{ $post->title }}</h2>
                            <p class="text-secondary">{{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                            <a href="{{ route('blog.show', $post) }}" class="stretched-link text-decoration-none fw-semibold">{{ __('site.common.read_article') }}</a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">{{ __('site.blog.empty') }}</div></div>
            @endforelse
        </div>
        <div class="mt-4">{{ $posts->links() }}</div>
    </div>
</main>
@endsection
