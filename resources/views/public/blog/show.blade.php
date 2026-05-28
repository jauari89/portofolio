@extends('layouts.public')

@section('title', $post->title.' | Blog')
@section('meta_description', $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 150))

@section('content')
<main>
    <section class="section section-soft">
        <div class="container">
            <a href="{{ route('blog.index') }}" class="text-decoration-none fw-semibold">&larr; {{ __('site.common.back_to_blog') }}</a>
            <div class="row g-5 mt-2 align-items-center">
                <div class="col-lg-7">
                    <div class="text-info fw-bold mb-2">{{ $post->category ?: __('site.common.article') }} &middot; {{ $post->published_at?->format('d M Y') }}</div>
                    <h1 class="fw-bold display-5">{{ $post->title }}</h1>
                    @if($post->excerpt)
                        <p class="lead text-secondary">{{ $post->excerpt }}</p>
                    @endif
                </div>
                <div class="col-lg-5">
                    <div class="card card-clean overflow-hidden">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}" class="w-100" style="aspect-ratio:16/10;object-fit:cover;">
                        @else
                            <div class="media-placeholder">{{ $post->category ?: __('site.common.article') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <article class="col-lg-8 fs-5 text-secondary">
                    {!! nl2br(e($post->content)) !!}
                </article>
                <aside class="col-lg-4">
                    <div class="card card-clean p-4">
                        <h2 class="h5 fw-bold">{{ __('site.common.latest_articles') }}</h2>
                        <div class="list-group list-group-flush mt-2">
                            @forelse($latestPosts as $latest)
                                <a href="{{ route('blog.show', $latest) }}" class="list-group-item list-group-item-action px-0">
                                    <strong>{{ $latest->title }}</strong>
                                    <div class="small text-muted">{{ $latest->published_at?->format('d M Y') }}</div>
                                </a>
                            @empty
                                <div class="text-muted">{{ __('site.blog.no_other_articles') }}</div>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>
@endsection
