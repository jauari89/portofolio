<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Portfolio;
use App\Models\Publication;
use App\Models\Supervision;
use App\Models\TeachingCourse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'Portfolio' => Portfolio::query()->count(),
                'Published Portfolio' => Portfolio::query()->published()->count(),
                'Publications' => Publication::query()->count(),
                'Teaching Courses' => TeachingCourse::query()->count(),
                'Supervisions' => Supervision::query()->count(),
                'Blog Posts' => BlogPost::query()->count(),
                'Unread Messages' => ContactMessage::query()->unread()->count(),
            ],
            'latestMessages' => ContactMessage::query()->latest()->take(5)->get(),
            'latestPosts' => BlogPost::query()->latest()->take(5)->get(),
        ]);
    }
}
