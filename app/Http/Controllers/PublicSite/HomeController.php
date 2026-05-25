<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Experience;
use App\Models\HeroSection;
use App\Models\Portfolio;
use App\Models\ProfileSection;
use App\Models\Publication;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Models\Stat;
use App\Models\Supervision;
use App\Models\TeachingCourse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $portfolios = Portfolio::query()
            ->published()
            ->ordered()
            ->latest('year')
            ->take(9)
            ->get();

        return view('public.home', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'hero' => HeroSection::current(),
            'stats' => Stat::query()->active()->ordered()->get(),
            'skills' => Skill::query()->active()->ordered()->get(),
            'services' => Service::query()->active()->ordered()->get(),
            'experiences' => Experience::query()->active()->ordered()->orderByDesc('start_year')->get(),
            'portfolios' => $portfolios,
            'portfolioCategories' => $portfolios->pluck('category')->unique()->values(),
            'publications' => Publication::query()->active()->orderByDesc('year')->ordered()->take(6)->get(),
            'teachingCourses' => TeachingCourse::query()->active()->ordered()->get(),
            'supervisionsByYear' => Supervision::query()
                ->active()
                ->whereNotNull('academic_year')
                ->orderBy('student_name')
                ->get()
                ->groupBy('academic_year')
                ->sortKeysDesc(),
            'blogPosts' => BlogPost::query()->published()->latest('published_at')->take(3)->get(),
            'socialLinks' => SocialLink::query()->active()->ordered()->get(),
        ]);
    }
}
