<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ProfileSection;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('category')->toString();

        $posts = BlogPost::query()
            ->published()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('public.blog.index', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'posts' => $posts,
            'categories' => BlogPost::query()->published()->whereNotNull('category')->distinct()->pluck('category'),
            'selectedCategory' => $category,
        ]);
    }

    public function show(BlogPost $blogPost): View
    {
        abort_unless($blogPost->status === 'published', 404);

        return view('public.blog.show', [
            'setting' => SiteSetting::current(),
            'profile' => ProfileSection::current(),
            'post' => $blogPost,
            'latestPosts' => BlogPost::query()
                ->published()
                ->where('id', '!=', $blogPost->id)
                ->latest('published_at')
                ->take(4)
                ->get(),
        ]);
    }
}
