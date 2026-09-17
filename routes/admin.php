<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SkillController;
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
});
