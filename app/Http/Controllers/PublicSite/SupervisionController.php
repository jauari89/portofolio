<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\ProfileSection;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Supervision;
use Illuminate\View\View;

class SupervisionController extends Controller
{
    public function showYear(string $year): View
    {
        $supervisions = Supervision::query()
            ->active()
            ->where('academic_year', $year)
            ->orderBy('student_name')
            ->get();

        abort_if($supervisions->isEmpty(), 404);

        $yearStats = Supervision::query()
            ->active()
            ->selectRaw('academic_year, COUNT(*) as total')
            ->whereNotNull('academic_year')
            ->groupBy('academic_year')
            ->orderByDesc('academic_year')
            ->get();

        return view('public.supervisions.year', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'socialLinks' => SocialLink::query()->active()->ordered()->get(),
            'year' => $year,
            'supervisions' => $supervisions,
            'yearStats' => $yearStats,
        ]);
    }
}
