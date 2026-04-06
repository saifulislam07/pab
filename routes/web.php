<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/mission-vision', 'missionVision')->name('mission-vision');
    Route::get('/team', 'team')->name('team');
    Route::get('/members', 'members')->name('members');
    Route::get('/members/{member}', 'memberShow')->name('members.show');
    Route::get('/registration', 'registration')->name('registration');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/gallery-items', 'galleryItems')->name('gallery.items');
    Route::get('/contact', 'contact')->name('contact');
});

Route::middleware(['auth', 'verified', 'profile.complete'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('member.dashboard');
    })->name('dashboard');

    Route::get('/member/dashboard', [App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');

    // Member Profile Completion
    Route::get('/member/profile/complete', [App\Http\Controllers\Member\ProfileController::class, 'edit'])->name('member.profile.edit');
    Route::put('/member/profile/complete', [App\Http\Controllers\Member\ProfileController::class, 'update'])->name('member.profile.update');

    // Membership Management for Members
    Route::get('/member/membership', [App\Http\Controllers\Member\MembershipController::class, 'index'])->name('member.membership.index');
    Route::get('/member/membership/apply', [App\Http\Controllers\Member\MembershipController::class, 'apply'])->name('member.membership.apply');
    Route::post('/member/membership/apply', [App\Http\Controllers\Member\MembershipController::class, 'store'])->name('member.membership.store');

    // District API for cascading dropdown
    Route::get('/api/districts/{division}', function ($division) {
        return \App\Models\District::where('division', $division)->orderBy('name')->pluck('name');
    })->name('api.districts');

    // Generic Profile Redirect
    Route::get('/profile', function () {
        return auth()->user()->isAdmin()
        ? redirect()->route('admin.profile.edit')
        : redirect()->route('member.profile.edit');
    })->name('profile.edit');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Profile
    Route::get('/admin/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/admin/about', [App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/admin/about', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');

    Route::get('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    Route::get('/admin/settings/smtp', [App\Http\Controllers\Admin\SettingController::class, 'smtp'])->name('admin.settings.smtp');
    Route::put('/admin/settings/smtp', [App\Http\Controllers\Admin\SettingController::class, 'smtpUpdate'])->name('admin.settings.smtp.update');

    Route::get('/admin/sliders', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('admin.sliders.index');
    Route::get('/admin/sliders/create', [App\Http\Controllers\Admin\SliderController::class, 'create'])->name('admin.sliders.create');
    Route::post('/admin/sliders', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('admin.sliders.store');
    Route::get('/admin/sliders/{slider}/edit', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('admin.sliders.edit');
    Route::put('/admin/sliders/{slider}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('admin.sliders.update');
    Route::delete('/admin/sliders/{slider}', [App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('admin.sliders.destroy');

    Route::get('/admin/mission-vision', [App\Http\Controllers\Admin\MissionVisionController::class, 'edit'])->name('admin.mission-vision.edit');
    Route::put('/admin/mission-vision', [App\Http\Controllers\Admin\MissionVisionController::class, 'update'])->name('admin.mission-vision.update');

    Route::get('admin/gallery/batch', [App\Http\Controllers\Admin\GalleryController::class, 'batchCreate'])->name('admin.gallery.batch');
    Route::post('admin/gallery/batch', [App\Http\Controllers\Admin\GalleryController::class, 'batchStore'])->name('admin.gallery.batch.store');
    Route::resource('admin/gallery', App\Http\Controllers\Admin\GalleryController::class)->names('admin.gallery');
    Route::resource('admin/categories', App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');

    // New routes for Team and Members
    Route::resource('admin/team', App\Http\Controllers\Admin\TeamMemberController::class)->names('admin.team');
    Route::get('admin/members/export', [App\Http\Controllers\Admin\MemberController::class, 'exportCsv'])->name('admin.members.export');
    Route::get('admin/members', [App\Http\Controllers\Admin\MemberController::class, 'index'])->name('admin.members.index');
    Route::get('admin/members/{member}', [App\Http\Controllers\Admin\MemberController::class, 'show'])->name('admin.members.show');
    Route::patch('admin/members/{member}/status', [App\Http\Controllers\Admin\MemberController::class, 'updateStatus'])->name('admin.members.update-status');
    Route::put('admin/members/{member}/password', [App\Http\Controllers\Admin\MemberController::class, 'updatePassword'])->name('admin.members.update-password');
    Route::delete('admin/members/{member}', [App\Http\Controllers\Admin\MemberController::class, 'destroy'])->name('admin.members.destroy');

    // Sponsor & Event Routes
    Route::resource('admin/sponsors', App\Http\Controllers\Admin\SponsorController::class)->names('admin.sponsors');
    Route::post('admin/sponsors/settings', [App\Http\Controllers\Admin\SponsorController::class, 'updateSettings'])->name('admin.sponsors.update-settings');
    Route::resource('admin/events', App\Http\Controllers\Admin\EventController::class)->names('admin.events');

    // Program Routes
    Route::get('admin/programs/{program}/registrations', [App\Http\Controllers\Admin\ProgramController::class, 'registrations'])->name('admin.programs.registrations');
    Route::get('admin/programs/{program}/registrations/export', [App\Http\Controllers\Admin\ProgramController::class, 'exportRegistrations'])->name('admin.programs.registrations.export');
    Route::patch('admin/programs/registrations/{registration}/status', [App\Http\Controllers\Admin\ProgramController::class, 'updateRegistrationStatus'])->name('admin.programs.registrations.status');
    Route::get('admin/programs/registrations/{registration}', [App\Http\Controllers\Admin\ProgramController::class, 'showRegistration'])->name('admin.programs.registrations.show');
    Route::resource('admin/programs', App\Http\Controllers\Admin\ProgramController::class)->names('admin.programs');

    // Advertisements
    Route::resource('admin/advertisements', App\Http\Controllers\Admin\AdvertisementController::class)->names('admin.advertisements');

    // Menus
    Route::resource('admin/menus', App\Http\Controllers\Admin\MenuController::class)->names('admin.menus');
    Route::post('admin/menus/reorder', [App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('admin.menus.reorder');

    // User & RBAC Management
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class)->names('admin.users')->only(['index', 'update', 'destroy']);
    Route::resource('admin/roles', App\Http\Controllers\Admin\RoleController::class)->names('admin.roles');
    Route::resource('admin/permissions', App\Http\Controllers\Admin\PermissionController::class)->names('admin.permissions')->only(['index', 'store', 'destroy']);

    // Financial Management
    Route::controller(App\Http\Controllers\Admin\FinancialController::class)->group(function () {
        Route::get('admin/finance/categories', 'categories')->name('admin.finance.categories');
        Route::post('admin/finance/categories', 'storeCategory')->name('admin.finance.categories.store');
        Route::put('admin/finance/categories/{category}', 'updateCategory')->name('admin.finance.categories.update');
        Route::delete('admin/finance/categories/{category}', 'destroyCategory')->name('admin.finance.categories.destroy');

        Route::get('admin/finance/income', 'income')->name('admin.finance.income');
        Route::get('admin/finance/expense', 'expense')->name('admin.finance.expense');
        Route::get('admin/finance/report', 'report')->name('admin.finance.report');
        Route::post('admin/finance/transaction', 'storeTransaction')->name('admin.finance.transaction.store');
        Route::put('admin/finance/transaction/{transaction}', 'updateTransaction')->name('admin.finance.transaction.update');
        Route::delete('admin/finance/transaction/{transaction}', 'destroyTransaction')->name('admin.finance.transaction.destroy');
    });

    // Membership Management for Admins
    Route::get('admin/membership', [App\Http\Controllers\Admin\MembershipController::class, 'index'])->name('admin.membership.index');
    Route::post('admin/membership/{member}/approve', [App\Http\Controllers\Admin\MembershipController::class, 'approve'])->name('admin.membership.approve');
    Route::post('admin/membership/{member}/reject', [App\Http\Controllers\Admin\MembershipController::class, 'reject'])->name('admin.membership.reject');
});

// Frontend Event Routes
Route::get('/events', [App\Http\Controllers\FrontendController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [App\Http\Controllers\FrontendController::class, 'eventShow'])->name('events.show');

// Frontend Program Routes
Route::get('/programs', [App\Http\Controllers\FrontendController::class, 'programs'])->name('programs.index');
Route::get('/programs/{slug}', [App\Http\Controllers\FrontendController::class, 'programShow'])->name('programs.show');
Route::post('/programs/{slug}/register', [App\Http\Controllers\FrontendController::class, 'programRegister'])->name('programs.register');

require __DIR__ . '/auth.php';
