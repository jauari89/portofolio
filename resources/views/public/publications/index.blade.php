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
            <form method="GET" class="d-flex gap-2 align-self-lg-end">
                <select name="year" class="form-select">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" @selected((int) $selectedYear === (int) $year)>{{ $year }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary">Filter</button>
            </form>
        </div>

        <div class="card card-clean overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:90px;">Year</th>
                            <th>Publication</th>
                            <th>Venue</th>
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
