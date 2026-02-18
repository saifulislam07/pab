<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/mission-vision', 'missionVision')->name('mission-vision');
    Route::get('/team', 'team')->name('team');
    Route::get('/members', 'members')->name('members');
    Route::get('/registration', 'registration')->name('registration');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/contact', 'contact')->name('contact');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/member/dashboard', [App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/about', [App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/admin/about', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');

    Route::get('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    Route::get('/admin/sliders', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('admin.sliders.index');
    Route::get('/admin/sliders/create', [App\Http\Controllers\Admin\SliderController::class, 'create'])->name('admin.sliders.create');
    Route::post('/admin/sliders', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('admin.sliders.store');
    Route::get('/admin/sliders/{slider}/edit', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('admin.sliders.edit');
    Route::put('/admin/sliders/{slider}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('admin.sliders.update');
    Route::delete('/admin/sliders/{slider}', [App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('admin.sliders.destroy');

    Route::get('/admin/mission-vision', [App\Http\Controllers\Admin\MissionVisionController::class, 'edit'])->name('admin.mission-vision.edit');
    Route::put('/admin/mission-vision', [App\Http\Controllers\Admin\MissionVisionController::class, 'update'])->name('admin.mission-vision.update');

    Route::resource('admin/gallery', App\Http\Controllers\Admin\GalleryController::class)->names('admin.gallery');
    Route::resource('admin/categories', App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');

    // New routes for Team and Members
    Route::resource('admin/team', App\Http\Controllers\Admin\TeamMemberController::class)->names('admin.team');
    Route::get('admin/members', [App\Http\Controllers\Admin\MemberController::class, 'index'])->name('admin.members.index');
    Route::patch('admin/members/{member}/status', [App\Http\Controllers\Admin\MemberController::class, 'updateStatus'])->name('admin.members.update-status');
    Route::delete('admin/members/{member}', [App\Http\Controllers\Admin\MemberController::class, 'destroy'])->name('admin.members.destroy');

    // Sponsor & Event Routes
    Route::resource('admin/sponsors', App\Http\Controllers\Admin\SponsorController::class)->names('admin.sponsors');
    Route::resource('admin/events', App\Http\Controllers\Admin\EventController::class)->names('admin.events');

    // User & RBAC Management
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class)->names('admin.users')->only(['index', 'update', 'destroy']);
    Route::resource('admin/roles', App\Http\Controllers\Admin\RoleController::class)->names('admin.roles');
    Route::resource('admin/permissions', App\Http\Controllers\Admin\PermissionController::class)->names('admin.permissions')->only(['index', 'store', 'destroy']);
});

// Frontend Event Routes
Route::get('/events', [App\Http\Controllers\FrontendController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [App\Http\Controllers\FrontendController::class, 'eventShow'])->name('events.show');

require __DIR__ . '/auth.php';
