@extends('layouts.public')

@section('title', ($setting->site_title ?? 'Jauari Akhmad Nur Hasim').' | Portfolio')

@section('content')
<header id="home" class="hero d-flex align-items-center" style="{{ $hero->background_image ? '--hero-bg: url('.asset('storage/'.$hero->background_image).')' : '' }}">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 reveal">
                <span class="chip mb-4"><span class="chip-dot"></span>{{ $profile->professional_title ?: $hero->subheadline }}</span>
                <h1 class="fw-bold mb-4">{{ $hero->headline ?: $profile->full_name }}</h1>
                <p class="lead hero-copy mb-4">{{ $hero->description ?: $profile->short_description }}</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ $hero->primary_button_url ?: '#portfolio' }}" class="btn btn-primary btn-lg">
                        {{ $hero->primary_button_text ?: 'View Portfolio' }}
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ $hero->secondary_button_url ?: '#contact' }}" class="btn btn-outline-light btn-lg">
                        {{ $hero->secondary_button_text ?: 'Contact Me' }}
                    </a>
                    @if($setting->cv_file)
                        <a href="{{ asset('storage/'.$setting->cv_file) }}" class="btn btn-light btn-lg" target="_blank" rel="noopener">Download CV</a>
                    @endif
                </div>
                @if($stats->isNotEmpty())
                    <dl class="row g-4 mt-5 mb-0">
                        @foreach($stats->take(4) as $stat)
                            <div class="col-6 col-md-3">
                                <dt class="hero-stat-label">{{ $stat->label }}</dt>
                                <dd class="hero-stat-value mb-0">{{ $stat->value }}+</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif
            </div>
            <div class="col-lg-5 d-flex justify-content-lg-end justify-content-center reveal reveal-delay-2">
                <div class="profile-frame">
                    @if($profile->profile_photo)
                        <img src="{{ asset('storage/'.$profile->profile_photo) }}" alt="{{ $profile->full_name }}">
                    @else
                        <div class="profile-placeholder">JA</div>
                    @endif
                    <div class="profile-caption">
                        <div class="small text-uppercase opacity-75 fw-semibold">{{ $profile->professional_title ?: 'Lecturer, Software Engineer' }}</div>
                        <div class="fw-semibold">{{ $profile->location ?: 'Surabaya, Jawa Timur' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    <section class="section">
        <div class="container">
            <div class="section-title">
                <div class="section-kicker">Academic Profiles</div>
                <h2 class="fw-bold mt-2">Citation Metrics & Research Identity</h2>
            </div>
            <div class="row g-4">
                @php
                    $metricCards = $academicMetrics->isNotEmpty() ? $academicMetrics : $stats->take(4);
                @endphp
                @forelse($metricCards as $metric)
                    <div class="col-sm-6 col-lg-3">
                        <article class="card card-clean p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <span class="icon-box"><i class="{{ $metric->icon ?: 'bi bi-bar-chart' }}"></i></span>
                                @if(! empty($metric->source_url))
                                    <a href="{{ $metric->source_url }}" target="_blank" rel="noopener" class="text-muted small stretched-link" aria-label="Open {{ $metric->label }} source">
                                        <i class="bi bi-arrow-up-right"></i>
                                    </a>
                                @else
                                    <span class="text-muted small"><i class="bi bi-arrow-up-right"></i></span>
                                @endif
                            </div>
                            <div class="small text-uppercase text-muted fw-bold mb-1" style="letter-spacing:.12em;">{{ $metric->label }}</div>
                            <div class="metric-value fw-bold mb-0">{{ $metric->value }}{{ $metric->suffix }}</div>
                            @if(! empty($metric->source_name))
                                <div class="small text-muted mt-2">{{ $metric->source_name }}</div>
                            @endif
                            @if(! empty($metric->description))
                                <p class="small text-secondary mt-3 mb-0">{{ $metric->description }}</p>
                            @endif
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info mb-0">Statistik profesional siap ditambahkan dari admin panel.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="about" class="section">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5">
                    <div class="section-title">
                        <div class="section-kicker">About</div>
                        <h2 class="fw-bold mt-2">{{ $profile->full_name }}</h2>
                    </div>
                    <div class="card card-clean p-4">
                        <div class="d-flex gap-3 mb-3">
                            <span class="icon-box"><i class="bi bi-geo-alt"></i></span>
                            <div><div class="text-muted small">Location</div><strong>{{ $profile->location ?: 'Lokasi dapat diperbarui dari admin panel' }}</strong></div>
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <span class="icon-box"><i class="bi bi-envelope"></i></span>
                            <div><div class="text-muted small">Email</div><strong>{{ $profile->primary_email ?: 'Email utama belum tersedia' }}</strong></div>
                        </div>
                        @if($profile->secondary_email)
                            <div class="d-flex gap-3">
                                <span class="icon-box"><i class="bi bi-envelope-paper"></i></span>
                                <div><div class="text-muted small">Alternative Email</div><strong>{{ $profile->secondary_email }}</strong></div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <p class="fs-5 text-secondary">{{ $profile->short_description }}</p>
                    <div class="text-secondary">{!! nl2br(e($profile->long_description ?: 'Profil profesional ini dapat diperbarui melalui admin panel untuk menampilkan fokus akademik, rekam jejak pengembangan sistem, penelitian, dan pembimbingan mahasiswa.')) !!}</div>
                    <div class="row g-3 mt-4">
                        @forelse($stats as $stat)
                            <div class="col-6 col-md-3">
                                <div class="card card-clean p-3 h-100">
                                    <div class="h3 fw-bold mb-0">{{ $stat->value }}+</div>
                                    <div class="text-muted small">{{ $stat->label }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info mb-0">Statistik profesional siap ditambahkan dari admin panel.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="section section-soft">
        <div class="container">
            <div class="section-title">
                <div class="section-kicker">Expertise / Services</div>
                <h2 class="fw-bold mt-2">Academic Technology, Systems, and Digital Media</h2>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-6 col-xl-4">
                        <article class="card card-clean h-100 p-4">
                            <span class="icon-box mb-3"><i class="{{ $service->icon ?: 'bi bi-code-square' }}"></i></span>
                            <h3 class="h5 fw-bold">{{ $service->title }}</h3>
                            <p class="text-secondary mb-0">{{ $service->description }}</p>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="skills" class="section">
        <div class="container">
            <div class="section-title">
                <div class="section-kicker">Skills</div>
                <h2 class="fw-bold mt-2">Technology Stack & Capabilities</h2>
            </div>
            <div class="row g-4">
                @foreach($skills as $skill)
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div><strong>{{ $skill->name }}</strong> <span class="text-muted small">{{ $skill->category }}</span></div>
                            <span class="small fw-semibold">{{ $skill->percentage }}%</span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="{{ $skill->name }}" aria-valuenow="{{ $skill->percentage }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-info" style="width: {{ $skill->percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="experience" class="section section-soft">
        <div class="container">
            <div class="section-title">
                <div class="section-kicker">Education & Experience</div>
                <h2 class="fw-bold mt-2">Professional Timeline</h2>
            </div>
            <div class="timeline">
                @foreach($experiences as $experience)
                    <article class="timeline-item">
                        <span class="badge text-bg-info text-white mb-2">{{ ucfirst($experience->type) }}</span>
                        <h3 class="h5 fw-bold mb-1">{{ $experience->title }}</h3>
                        <div class="text-muted mb-2">{{ $experience->institution }}{{ $experience->location ? ' - '.$experience->location : '' }} · {{ $experience->start_year }} - {{ $experience->end_year ?: 'Present' }}</div>
                        <p class="text-secondary mb-0">{{ $experience->description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="portfolio" class="section">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
                <div class="section-title mb-0">
                    <div class="section-kicker">Works / Portfolio</div>
                    <h2 class="fw-bold mt-2">Selected Systems and Projects</h2>
                </div>
                <div class="d-flex flex-wrap gap-2 align-self-lg-end">
                    <button class="btn btn-sm btn-primary portfolio-filter" data-filter="all">All</button>
                    @foreach($portfolioCategories as $category)
                        <button class="btn btn-sm btn-outline-primary portfolio-filter" data-filter="{{ $category }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>
            <div class="row g-4" id="portfolioGrid">
                @forelse($portfolios as $portfolio)
                    <div class="col-md-6 col-xl-4 portfolio-item" data-category="{{ $portfolio->category }}">
                        <article class="card card-clean portfolio-card h-100 overflow-hidden">
                            @if($portfolio->thumbnail)
                                <img src="{{ asset('storage/'.$portfolio->thumbnail) }}" alt="{{ $portfolio->title }}">
                            @else
                                <div class="media-placeholder">{{ $portfolio->category }}</div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>{{ $portfolio->category }}</span>
                                    <span>{{ $portfolio->year }}</span>
                                </div>
                                <h3 class="h5 fw-bold">{{ $portfolio->title }}</h3>
                                <p class="text-secondary">{{ $portfolio->short_description }}</p>
                                <a href="{{ route('portfolio.show', $portfolio) }}" class="stretched-link text-decoration-none fw-semibold">View detail</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-info">Portfolio akan tampil setelah item berstatus published ditambahkan dari admin panel.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="publications" class="section section-soft">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                <div class="section-title mb-0">
                    <div class="section-kicker">Publications</div>
                    <h2 class="fw-bold mt-2">Academic Publications</h2>
                </div>
                <a href="{{ route('publications.index') }}" class="btn btn-outline-primary align-self-md-end">View All</a>
            </div>
            <div class="row g-3">
                @foreach($publications as $publication)
                    <div class="col-lg-6">
                        <article class="card card-clean p-4 h-100">
                            <div class="text-info fw-bold mb-2">{{ $publication->year }}</div>
                            <h3 class="h5">{{ $publication->title }}</h3>
                            <p class="text-muted mb-2">{{ $publication->authors }}</p>
                            <div class="text-secondary small">{{ $publication->journal_or_conference ?: $publication->publisher }}</div>
                            @if($publication->volume || $publication->issue || $publication->pages)
                                <div class="text-secondary small">
                                    @if($publication->volume) Vol. {{ $publication->volume }} @endif
                                    @if($publication->issue) No. {{ $publication->issue }} @endif
                                    @if($publication->pages) pp. {{ $publication->pages }} @endif
                                </div>
                            @endif
                            @if($publication->url)
                                <a href="{{ $publication->url }}" target="_blank" rel="noopener" class="fw-semibold mt-2 d-inline-block">Publication link</a>
                            @endif
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="teaching" class="section">
        <div class="container">
            <div class="section-title">
                <div class="section-kicker">Teaching / Lecturer</div>
                <h2 class="fw-bold mt-2">Courses and Academic Mentoring</h2>
            </div>
            <div class="row g-3">
                @foreach($teachingCourses as $course)
                    <div class="col-md-6 col-xl-4">
                        <article class="card card-clean p-4 h-100">
                            <h3 class="h5 fw-bold">{{ $course->course_name }}</h3>
                            <div class="text-muted small mb-2">{{ trim(($course->semester ? $course->semester.' · ' : '').($course->academic_year ?: '')) }}</div>
                            <p class="text-secondary">{{ $course->description ?: 'Deskripsi mata kuliah dapat diperbarui dari admin panel.' }}</p>
                            @if($course->material_url)
                                <a href="{{ $course->material_url }}" target="_blank" rel="noopener" class="fw-semibold">Course material</a>
                            @endif
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mt-5 mb-3">
                <div>
                    <div class="section-kicker">Student Supervision</div>
                    <h3 class="fw-bold mt-2 mb-0">Academic Guidance & Mentoring</h3>
                </div>
            </div>
            @if($supervisionsByYear->isEmpty())
                <div class="alert alert-info mb-0">Data mahasiswa bimbingan dapat ditambahkan dari admin panel.</div>
            @else
                {{-- Year switcher: pills horizontal scroll, click → swap table di bawahnya --}}
                <div class="year-switcher mb-3" role="tablist">
                    @foreach($supervisionsByYear as $year => $rows)
                        <button type="button"
                                class="year-pill {{ $loop->first ? 'active' : '' }}"
                                data-bs-toggle="tab"
                                data-bs-target="#sup-year-{{ $year }}"
                                role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            <span class="year-pill-year">{{ $year }}</span>
                            <span class="year-pill-count">{{ $rows->count() }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="tab-content">
                    @foreach($supervisionsByYear as $year => $rows)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                             id="sup-year-{{ $year }}" role="tabpanel">
                            <div class="card card-clean overflow-hidden">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:60px;">#</th>
                                                <th style="width:140px;">NRP</th>
                                                <th style="width:240px;">Nama Mahasiswa</th>
                                                <th>Judul Proyek</th>
                                                <th style="width:110px;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $i => $s)
                                                <tr>
                                                    <td class="text-muted">{{ $i + 1 }}</td>
                                                    <td class="font-monospace small">{{ $s->student_identifier ?: '-' }}</td>
                                                    <td class="fw-semibold">{{ $s->student_name }}</td>
                                                    <td>
                                                        <div>{{ $s->project_title }}</div>
                                                        @if($s->program)
                                                            <div class="text-muted small mt-1">{{ $s->program }}</div>
                                                        @endif
                                                        @if($s->result_url)
                                                            <a href="{{ $s->result_url }}" target="_blank" rel="noopener" class="small fw-semibold">
                                                                View result <i class="bi bi-box-arrow-up-right"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge text-bg-{{ $s->status === 'completed' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($s->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <style>
                .year-switcher {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                }
                .year-pill {
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    padding: 6px 14px;
                    border: 1px solid var(--line);
                    background: #fff;
                    border-radius: 999px;
                    font-size: .85rem;
                    font-weight: 600;
                    color: var(--muted);
                    cursor: pointer;
                    transition: all .15s ease;
                }
                .year-pill:hover {
                    border-color: var(--cyan);
                    color: var(--cyan);
                }
                .year-pill.active {
                    background: var(--cyan);
                    border-color: var(--cyan);
                    color: #fff;
                    box-shadow: 0 4px 12px rgba(14, 165, 183, .25);
                }
                .year-pill-year { font-weight: 700; }
                .year-pill-count {
                    background: rgba(0,0,0,.08);
                    color: inherit;
                    padding: 1px 8px;
                    border-radius: 999px;
                    font-size: .72rem;
                    line-height: 1.4;
                }
                .year-pill.active .year-pill-count {
                    background: rgba(255,255,255,.25);
                }
            </style>
        </div>
    </section>

    <section id="blog" class="section section-soft">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                <div class="section-title mb-0">
                    <div class="section-kicker">Blog</div>
                    <h2 class="fw-bold mt-2">Latest Notes</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary align-self-md-end">All Articles</a>
            </div>
            <div class="row g-4">
                @forelse($blogPosts as $post)
                    <div class="col-md-4">
                        <article class="card card-clean blog-card h-100 overflow-hidden">
                            @if($post->thumbnail)
                                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}">
                            @else
                                <div class="media-placeholder">{{ $post->category ?: 'Article' }}</div>
                            @endif
                            <div class="card-body">
                                <div class="text-muted small mb-2">{{ $post->published_at?->format('d M Y') }} · {{ $post->category }}</div>
                                <h3 class="h5 fw-bold">{{ $post->title }}</h3>
                                <p class="text-secondary">{{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->content), 110) }}</p>
                                <a href="{{ route('blog.show', $post) }}" class="stretched-link text-decoration-none fw-semibold">Read article</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-info">Artikel terbaru akan tampil setelah dipublikasikan dari admin panel.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="contact" class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="section-title">
                        <div class="section-kicker">Contact</div>
                        <h2 class="fw-bold mt-2">Let's Connect</h2>
                    </div>
                    <p class="text-secondary">Untuk kolaborasi akademik, pengembangan sistem, pembimbingan, atau diskusi riset, silakan kirim pesan melalui form ini.</p>
                    <div class="d-flex flex-column gap-2">
                        @if($profile->primary_email)<a href="mailto:{{ $profile->primary_email }}" class="text-decoration-none"><i class="bi bi-envelope me-2"></i>{{ $profile->primary_email }}</a>@endif
                        @if($profile->location)<span><i class="bi bi-geo-alt me-2"></i>{{ $profile->location }}</span>@endif
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        @foreach($socialLinks as $social)
                            <a class="btn btn-outline-primary btn-sm" href="{{ $social->url }}" target="_blank" rel="noopener"><i class="{{ $social->icon ?: 'bi bi-link-45deg' }} me-1"></i>{{ $social->platform }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-7">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}" class="card card-clean p-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Name</label>
                                <input id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="subject">Subject</label>
                                <input id="subject" name="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" required>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="message">Message</label>
                                <textarea id="message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary btn-lg" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.portfolio-filter').forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            document.querySelectorAll('.portfolio-filter').forEach((item) => item.classList.replace('btn-primary', 'btn-outline-primary'));
            button.classList.replace('btn-outline-primary', 'btn-primary');
            document.querySelectorAll('.portfolio-item').forEach((item) => {
                item.classList.toggle('d-none', filter !== 'all' && item.dataset.category !== filter);
            });
        });
    });
</script>
@endpush
