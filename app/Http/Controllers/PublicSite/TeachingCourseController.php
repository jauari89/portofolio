<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\ProfileSection;
use App\Models\SiteSetting;
use App\Models\TeachingCourse;
use Illuminate\View\View;

class TeachingCourseController extends Controller
{
    public function show(TeachingCourse $teachingCourse): View
    {
        abort_unless($teachingCourse->is_active, 404);

        $teachingCourse->load([
            'weeklyMaterials' => fn ($query) => $query->active()->orderBy('week_number'),
        ]);

        return view('public.teaching.show', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'course' => $teachingCourse,
            'relatedCourses' => TeachingCourse::query()
                ->active()
                ->whereKeyNot($teachingCourse->getKey())
                ->ordered()
                ->take(6)
                ->get(),
        ]);
    }
}
