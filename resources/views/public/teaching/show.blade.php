@extends('layouts.public')

@section('title', $course->course_name.' | '.__('site.teaching.title'))
@section('meta_description', $course->description ?: \Illuminate\Support\Str::limit(strip_tags($course->overview ?: $course->course_name), 150))

@section('content')
@php
    $materials = collect(preg_split('/\r\n|\r|\n/', (string) $course->materials))->map(fn ($line) => trim($line))->filter()->values();
    $projects = collect(preg_split('/\r\n|\r|\n/', (string) $course->sample_projects))->map(fn ($line) => trim($line))->filter()->values();
    $weeklyMaterials = $course->weeklyMaterials->keyBy('week_number');
@endphp

<main>
    <section class="section section-soft">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">{{ __('site.nav.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}#teaching" class="text-decoration-none">{{ __('site.nav.teaching') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $course->course_name }}</li>
                </ol>
            </nav>

            <div class="row g-5 align-items-start">
                <div class="col-lg-8">
                    <div class="section-kicker">{{ __('site.teaching.kicker') }}</div>
                    <h1 class="fw-bold display-5 mt-2">{{ $course->course_name }}</h1>
                    <p class="lead text-secondary mb-0">{{ $course->description ?: __('site.teaching.description_empty') }}</p>
                </div>
                <div class="col-lg-4">
                    <div class="card card-clean p-4">
                        <div class="d-flex flex-column gap-3">
                            @if($course->course_code)
                                <div>
                                    <div class="text-muted small">{{ __('site.teaching.course_code') }}</div>
                                    <strong>{{ $course->course_code }}</strong>
                                </div>
                            @endif
                            @if($course->semester)
                                <div>
                                    <div class="text-muted small">{{ __('site.teaching.semester') }}</div>
                                    <strong>{{ $course->semester }}</strong>
                                </div>
                            @endif
                            @if($course->academic_year)
                                <div>
                                    <div class="text-muted small">{{ __('site.teaching.academic_year') }}</div>
                                    <strong>{{ $course->academic_year }}</strong>
                                </div>
                            @endif
                            @unless($course->course_code || $course->semester || $course->academic_year)
                                <div class="text-muted">{{ __('site.teaching.meta_empty') }}</div>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <article class="card card-clean p-4 h-100">
                        <div class="section-kicker mb-2">{{ __('site.teaching.overview') }}</div>
                        <div class="fs-5 text-secondary">{!! nl2br(e($course->overview ?: $course->description ?: __('site.teaching.overview_empty'))) !!}</div>
                    </article>
                </div>
                <div class="col-lg-5">
                    <article class="card card-clean p-4 h-100">
                        <div class="section-kicker mb-2">{{ __('site.teaching.rps') }}</div>
                        <div class="text-secondary mb-3">{!! nl2br(e($course->rps_summary ?: __('site.teaching.rps_empty'))) !!}</div>
                        <div class="d-flex flex-wrap gap-2">
                            @if($course->rps_file)
                                <a href="{{ asset('storage/'.$course->rps_file) }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                                    <i class="bi bi-filetype-pdf me-1"></i>{{ __('site.teaching.open_rps_file') }}
                                </a>
                            @endif
                            @if($course->rps_url)
                                <a href="{{ $course->rps_url }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>{{ __('site.teaching.open_rps_url') }}
                                </a>
                            @endif
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
                <div class="section-title mb-0">
                    <div class="section-kicker">{{ __('site.teaching.weekly_materials') }}</div>
                    <h2 class="fw-bold mt-2">{{ __('site.teaching.materials') }}</h2>
                    <p class="text-secondary mb-0">{{ __('site.teaching.weekly_materials_subtitle') }}</p>
                </div>
                @if($course->material_url)
                    <a href="{{ $course->material_url }}" target="_blank" rel="noopener" class="btn btn-outline-primary align-self-lg-end">
                        {{ __('site.common.course_material') }} <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                @endif
            </div>

            <div class="row g-3">
                @foreach(range(1, 16) as $week)
                    @php
                        $material = $weeklyMaterials->get($week);
                        $pdfUrl = $material?->pdf_file ? asset('storage/'.$material->pdf_file) : $material?->material_url;
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <article class="card card-clean p-4 h-100">
                            <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                                <span class="chip">{{ __('site.teaching.week', ['number' => $week]) }}</span>
                                @if($pdfUrl)
                                    <a href="{{ $pdfUrl }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm flex-shrink-0">
                                        <i class="bi bi-filetype-pdf me-1"></i>{{ __('site.teaching.view_pdf') }}
                                    </a>
                                @else
                                    <span class="text-muted small flex-shrink-0">{{ __('site.teaching.pdf_empty') }}</span>
                                @endif
                            </div>
                            <h3 class="h6 fw-bold">{{ $material?->title ?: __('site.teaching.week', ['number' => $week]) }}</h3>
                            @if($material?->description)
                                <p class="text-secondary small mb-0">{{ $material->description }}</p>
                            @elseif($materials->get($week - 1))
                                <p class="text-secondary small mb-0">{{ $materials->get($week - 1) }}</p>
                            @else
                                <p class="text-secondary small mb-0">{{ __('site.teaching.materials_empty') }}</p>
                            @endif
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-12">
                    <article class="card card-clean p-4 h-100">
                        <div class="section-kicker mb-2">{{ __('site.teaching.sample_projects') }}</div>
                        @if($projects->isNotEmpty())
                            <div class="row g-3">
                                @foreach($projects as $project)
                                    <div class="col-md-4">
                                        <div class="d-flex gap-3 h-100">
                                            <span class="icon-box flex-shrink-0"><i class="bi bi-kanban"></i></span>
                                            <div class="text-secondary">{{ $project }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-secondary mb-0">{{ __('site.teaching.projects_empty') }}</p>
                        @endif
                    </article>
                </div>
            </div>
        </div>
    </section>

    @if($relatedCourses->isNotEmpty())
        <section class="section">
            <div class="container">
                <div class="section-title">
                    <div class="section-kicker">{{ __('site.teaching.related') }}</div>
                    <h2 class="fw-bold mt-2">{{ __('site.teaching.related_title') }}</h2>
                </div>
                <div class="row g-3">
                    @foreach($relatedCourses as $related)
                        <div class="col-md-6 col-xl-4">
                            <a href="{{ route('teaching.show', $related) }}" class="card card-clean p-4 h-100 text-decoration-none text-reset">
                                <h3 class="h5 fw-bold">{{ $related->course_name }}</h3>
                                <p class="text-secondary mb-0">{{ $related->description ?: __('site.home.course_empty') }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@endsection
