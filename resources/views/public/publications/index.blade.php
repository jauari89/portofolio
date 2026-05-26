@extends('layouts.public')

@section('title', 'Publications | '.($setting->site_name ?? 'Jauari Akhmad'))

@section('content')
<main class="section section-soft">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
            <div>
                <div class="section-kicker">Publications</div>
                <h1 class="fw-bold mt-2">Academic Publications</h1>
            </div>
            <form method="GET" class="row g-2 align-self-lg-end publication-filter" style="min-width:min(760px, 100%);">
                @if($currentSort)
                    <input type="hidden" name="sort" value="{{ $currentSort }}">
                    <input type="hidden" name="direction" value="{{ $currentDirection }}">
                @endif
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1" for="publication-search">Keyword</label>
                    <input id="publication-search" name="q" value="{{ $keyword }}" class="form-control" placeholder="Cari publikasi..." autocomplete="off">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1" for="publication-search-by">Field</label>
                    <select id="publication-search-by" name="search_by" class="form-select">
                        <option value="" @selected($selectedSearchColumn === '')>All fields</option>
                        @foreach($searchColumns as $column => $label)
                            <option value="{{ $column }}" @selected($selectedSearchColumn === $column)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1" for="publication-year">Year</label>
                    <input id="publication-year" name="year" value="{{ $selectedYear }}" class="form-control" placeholder="All years" list="publication-years" inputmode="numeric" autocomplete="off">
                    <datalist id="publication-years">
                    @foreach($years as $year)
                        <option value="{{ $year }}">
                    @endforeach
                    </datalist>
                </div>
                <div class="col-md-2 d-grid">
                    <label class="form-label small text-muted mb-1 d-none d-md-block">&nbsp;</label>
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="card card-clean overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            @foreach(['year' => 'Year', 'title' => 'Publication', 'journal_or_conference' => 'Venue'] as $column => $label)
                                @php
                                    $isActiveSort = $currentSort === $column;
                                    $nextDirection = $isActiveSort && $currentDirection === 'asc' ? 'desc' : 'asc';
                                    $sortUrl = route('publications.index', array_merge(request()->except(['page', 'sort', 'direction']), [
                                        'sort' => $column,
                                        'direction' => $nextDirection,
                                    ]));
                                @endphp
                                <th @if($column === 'year') style="width:90px;" @endif>
                                    <a href="{{ $sortUrl }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-reset">
                                        <span>{{ $label }}</span>
                                        @if($isActiveSort)
                                            <i class="bi bi-arrow-{{ $currentDirection === 'asc' ? 'up' : 'down' }} text-info"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                            @endforeach
                            <th style="width:120px;">Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publications as $publication)
                            <tr>
                                <td class="fw-bold text-info">{{ $publication->year }}</td>
                                <td>
                                    <strong>{{ $publication->title }}</strong>
                                    <div class="small text-muted">{{ $publication->authors }}</div>
                                    @if($publication->volume || $publication->issue || $publication->pages)
                                        <div class="small text-muted">
                                            @if($publication->volume) Vol. {{ $publication->volume }} @endif
                                            @if($publication->issue) No. {{ $publication->issue }} @endif
                                            @if($publication->pages) pp. {{ $publication->pages }} @endif
                                        </div>
                                    @endif
                                    @if($publication->doi)<div class="small">DOI: {{ $publication->doi }}</div>@endif
                                </td>
                                <td>{{ $publication->journal_or_conference ?: $publication->publisher }}</td>
                                <td>
                                    @if($publication->url)
                                        <a href="{{ $publication->url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">Open</a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">Publikasi belum tersedia atau belum aktif.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $publications->links() }}</div>
    </div>
</main>
@endsection
