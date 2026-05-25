<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\ProfileSection;
use App\Models\SiteSetting;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function show(Portfolio $portfolio): View
    {
        abort_unless($portfolio->status === 'published', 404);

        $related = Portfolio::query()
            ->published()
            ->where('id', '!=', $portfolio->id)
            ->where('category', $portfolio->category)
            ->ordered()
            ->take(3)
            ->get();

        return view('public.portfolios.show', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'portfolio' => $portfolio,
            'related' => $related,
        ]);
    }
}
