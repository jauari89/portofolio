@extends('layouts.public')

@section('title', $portfolio->title.' | Portfolio')
@section('meta_description', $portfolio->short_description)

@section('content')
<main>
    <section class="section section-soft">
        <div class="container">
            <a href="{{ route('home') }}#portfolio" class="text-decoration-none fw-semibold">&larr; Back to portfolio</a>
            <div class="row g-5 mt-2 align-items-start">
                <div class="col-lg-7">
                    <span class="badge text-bg-info text-white mb-3">{{ $portfolio->category }}</span>
                    <h1 class="fw-bold display-5">{{ $portfolio->title }}</h1>
                    <p class="lead text-secondary">{{ $portfolio->short_description }}</p>
                    <div class="d-flex flex-wrap gap-2 text-muted">
                        @if($portfolio->year)<span><i class="bi bi-calendar3 me-1"></i>{{ $portfolio->year }}</span>@endif
                        @if($portfolio->client_or_institution)<span><i class="bi bi-building me-1"></i>{{ $portfolio->client_or_institution }}</span>@endif
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card card-clean overflow-hidden">
                        @if($portfolio->thumbnail)
                            <img src="{{ asset('storage/'.$portfolio->thumbnail) }}" alt="{{ $portfolio->title }}" class="w-100" style="aspect-ratio:16/10;object-fit:cover;">
                        @else
                            <div class="media-placeholder">{{ $portfolio->category }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <article class="fs-5 text-secondary">
                        {!! nl2br(e($portfolio->content ?: 'Detail project dapat diperbarui dari admin panel, termasuk latar belakang, teknologi, hasil implementasi, dan dampaknya.')) !!}
                    </article>
                </div>
                <aside class="col-lg-4">
                    <div class="card card-clean p-4">
                        <h2 class="h5 fw-bold">Project Links</h2>
                        <div class="d-grid gap-2 mt-3">
                            @if($portfolio->demo_url)
                                <a class="btn btn-primary" href="{{ $portfolio->demo_url }}" target="_blank" rel="noopener">Open Demo</a>
                            @endif
                            @if($portfolio->repository_url)
                                <a class="btn btn-outline-primary" href="{{ $portfolio->repository_url }}" target="_blank" rel="noopener">Open Repository</a>
                            @endif
                            @unless($portfolio->demo_url || $portfolio->repository_url)
                                <div class="text-muted">Tautan demo atau repository belum tersedia.</div>
                            @endunless
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if($related->isNotEmpty())
        <section class="section section-soft">
            <div class="container">
                <h2 class="fw-bold mb-4">Related Works</h2>
                <div class="row g-4">
                    @foreach($related as $item)
                        <div class="col-md-4">
                            <article class="card card-clean h-100 p-4">
                                <div class="text-info fw-semibold mb-2">{{ $item->category }}</div>
                                <h3 class="h5 fw-bold">{{ $item->title }}</h3>
                                <p class="text-secondary">{{ $item->short_description }}</p>
                                <a href="{{ route('portfolio.show', $item) }}" class="stretched-link text-decoration-none fw-semibold">View detail</a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@endsection
