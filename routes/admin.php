<?php

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

    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('skills', SkillController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('experiences', ExperienceController::class)->except(['show']);

    Route::post('resumes/{resume}/activate', [ResumeController::class, 'activate'])->name('resumes.activate');
    Route::resource('resumes', ResumeController::class)->except(['show']);

    Route::resource('social-links', SocialLinkController::class)->except(['show']);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
