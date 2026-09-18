<?php

use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SocialLinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Route Group
|--------------------------------------------------------------------------
| Protected with 'auth' and 'admin' (EnsureUserIsAdmin) middleware.
| Prefix /admin and name admin.* are registered in bootstrap/app.php.
*/

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Portfolio & Content
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('skills', SkillController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('experiences', ExperienceController::class)->except(['show']);

    // Resumes & Downloads
    Route::post('resumes/{resume}/activate', [ResumeController::class, 'activate'])->name('resumes.activate');
    Route::resource('resumes', ResumeController::class)->except(['show']);

    // Blog & Tutorials
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('posts', BlogPostController::class)->except(['show']);

    // Inbox & Messages
    Route::post('messages/{message}/toggle-read', [ContactMessageController::class, 'toggleRead'])->name('messages.toggle-read');
    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

    // System Settings & Profiles
    Route::resource('social-links', SocialLinkController::class)->except(['show']);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
