<?php

use App\Http\Controllers\Admin\AcademicMetricController as AdminAcademicMetricController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController as AdminExperienceController;
use App\Http\Controllers\Admin\HeroSectionController as AdminHeroSectionController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Admin\SocialLinkController as AdminSocialLinkController;
use App\Http\Controllers\Admin\StatController as AdminStatController;
use App\Http\Controllers\Admin\SupervisionController as AdminSupervisionController;
use App\Http\Controllers\Admin\TeachingCourseController as AdminTeachingCourseController;
use App\Http\Controllers\Admin\TeachingCourseMaterialController as AdminTeachingCourseMaterialController;
use App\Http\Controllers\PublicSite\BlogController;
use App\Http\Controllers\PublicSite\ContactController;
use App\Http\Controllers\PublicSite\HomeController;
use App\Http\Controllers\PublicSite\PortfolioController;
use App\Http\Controllers\PublicSite\PublicationController;
use App\Http\Controllers\PublicSite\SupervisionController;
use App\Http\Controllers\PublicSite\TeachingCourseController;
use Illuminate\Support\Facades\Route;

Route::middleware('locale')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{blogPost:slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
    Route::get('/teaching/{teachingCourse:slug}', [TeachingCourseController::class, 'show'])->name('teaching.show');
    Route::get('/supervisions/{year}', [SupervisionController::class, 'showYear'])
        ->where('year', '[0-9]{4}')
        ->name('supervisions.year');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});
Route::redirect('/login', '/admin/login')->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::get('/about', [AdminProfileController::class, 'edit'])->name('about.edit');

        Route::get('/hero', [AdminHeroSectionController::class, 'edit'])->name('hero.edit');
        Route::put('/hero', [AdminHeroSectionController::class, 'update'])->name('hero.update');

        Route::get('/settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');

        Route::resource('stats', AdminStatController::class);
        Route::resource('academic-metrics', AdminAcademicMetricController::class);
        Route::resource('skills', AdminSkillController::class);
        Route::resource('services', AdminServiceController::class);
        Route::resource('experiences', AdminExperienceController::class);
        Route::resource('portfolios', AdminPortfolioController::class);
        Route::resource('publications', AdminPublicationController::class);
        Route::resource('teaching', AdminTeachingCourseController::class);
        Route::resource('teaching-materials', AdminTeachingCourseMaterialController::class);
        Route::resource('supervisions', AdminSupervisionController::class);
        Route::resource('blog', AdminBlogPostController::class);
        Route::resource('social-links', AdminSocialLinkController::class);

        Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('/contact-messages/{contactMessage}/status', [AdminContactMessageController::class, 'updateStatus'])->name('contact-messages.status');
        Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });
});
