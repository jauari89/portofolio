<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\ProfileSection;
use App\Models\Publication;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicationController extends Controller
{
    public function index(Request $request): View
    {
        $year = $request->integer('year') ?: null;
        $keyword = trim($request->string('q')->toString());
        $searchColumns = [
            'title' => 'Title',
            'authors' => 'Authors',
            'year' => 'Year',
            'journal_or_conference' => 'Venue',
            'publisher' => 'Publisher',
            'doi' => 'DOI',
        ];
        $sortColumns = [
            'year' => 'Year',
            'title' => 'Publication',
            'journal_or_conference' => 'Venue',
        ];
        $selectedSearchColumn = array_key_exists($request->string('search_by')->toString(), $searchColumns)
            ? $request->string('search_by')->toString()
            : '';
        $sortColumn = array_key_exists($request->string('sort')->toString(), $sortColumns)
            ? $request->string('sort')->toString()
            : 'year';
        $sortDirection = $request->string('direction')->lower()->toString() === 'asc' ? 'asc' : 'desc';
        $publications = Publication::query()
            ->active()
            ->when($year, fn ($query) => $query->where('year', $year))
            ->when($keyword !== '', function ($query) use ($keyword, $selectedSearchColumn, $searchColumns) {
                $query->where(function ($searchQuery) use ($keyword, $selectedSearchColumn, $searchColumns) {
                    if ($selectedSearchColumn) {
                        $searchQuery->where($selectedSearchColumn, 'like', '%'.$keyword.'%');

                        return;
                    }

                    foreach (array_keys($searchColumns) as $index => $column) {
                        $method = $index === 0 ? 'where' : 'orWhere';
                        $searchQuery->{$method}($column, 'like', '%'.$keyword.'%');
                    }
                });
            })
            ->orderBy($sortColumn, $sortDirection)
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('public.publications.index', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'keyword' => $keyword,
            'selectedYear' => $year,
            'selectedSearchColumn' => $selectedSearchColumn,
            'searchColumns' => $searchColumns,
            'sortColumns' => $sortColumns,
            'currentSort' => $sortColumn,
            'currentDirection' => $sortDirection,
            'years' => Publication::query()->active()->distinct()->orderByDesc('year')->pluck('year'),
            'publications' => $publications,
        ]);
    }
}
