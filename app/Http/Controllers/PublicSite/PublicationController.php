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

        return view('public.publications.index', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'selectedYear' => $year,
            'years' => Publication::query()->active()->distinct()->orderByDesc('year')->pluck('year'),
            'publications' => Publication::query()
                ->active()
                ->when($year, fn ($query) => $query->where('year', $year))
                ->orderByDesc('year')
                ->ordered()
                ->paginate(12)
                ->withQueryString(),
        ]);
    }
}
