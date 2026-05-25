@extends('layouts.public')

@section('title', 'Bimbingan Mahasiswa '.$year.' | '.($setting->site_name ?? 'Jauari Akhmad'))

@section('content')
<main class="section section-soft">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}#supervisions" class="text-decoration-none">Supervisions</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $year }}</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
            <div>
                <div class="section-kicker">Student Supervision</div>
                <h1 class="fw-bold mt-2 mb-0">Bimbingan Mahasiswa {{ $year }}</h1>
                <div class="text-muted mt-2">{{ $supervisions->count() }} mahasiswa dalam tahun {{ $year }}</div>
            </div>
        </div>

        <div class="card card-clean overflow-hidden mb-5">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th style="width:140px;">NRP</th>
                            <th style="width:220px;">Nama Mahasiswa</th>
                            <th>Judul Proyek</th>
                            <th style="width:120px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supervisions as $i => $s)
                            <tr>
                                <td class="text-muted">{{ $i + 1 }}</td>
                                <td class="font-monospace small">{{ $s->student_identifier ?: '-' }}</td>
                                <td class="fw-semibold">{{ $s->student_name }}</td>
                                <td>
                                    <div>{{ $s->project_title }}</div>
                                    @if($s->program)
                                        <div class="text-muted small mt-1">{{ $s->program }}</div>
                                    @endif
                                    @if($s->description)
                                        <div class="text-secondary small mt-1">{{ \Illuminate\Support\Str::limit($s->description, 200) }}</div>
                                    @endif
                                    @if($s->result_url)
                                        <a href="{{ $s->result_url }}" target="_blank" rel="noopener" class="small fw-semibold">View result <i class="bi bi-box-arrow-up-right"></i></a>
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

        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-3">
            <div>
                <div class="section-kicker">All Years</div>
                <h3 class="fw-bold mt-2 mb-0">Jelajah Tahun Lain</h3>
            </div>
        </div>
        <div class="row g-3">
            @foreach($yearStats as $stat)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('supervisions.year', $stat->academic_year) }}"
                       class="card card-clean p-3 h-100 text-decoration-none text-reset year-card {{ $stat->academic_year == $year ? 'year-card-active' : '' }}">
                        <div class="d-flex flex-column align-items-center text-center">
                            <div class="h3 fw-bold mb-0" style="color: var(--cyan);">{{ $stat->academic_year }}</div>
                            <div class="text-muted small">{{ $stat->total }} mahasiswa</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</main>

<style>
    .year-card { transition: transform .15s ease, box-shadow .15s ease; }
    .year-card:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(14, 165, 183, .18); border-color: var(--cyan); }
    .year-card-active { border-color: var(--cyan); background: linear-gradient(180deg, rgba(14,165,183,.06), transparent); }
</style>
@endsection
