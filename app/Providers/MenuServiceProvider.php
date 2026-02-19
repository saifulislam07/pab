<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        // Frontend Menus
        View::composer('layouts.frontend', function ($view) {
            $menus = Menu::active()
                ->frontend()
                ->topLevel()
                ->with(['children' => function ($query) {
                    $query->active();
                }])
                ->get();

            $view->with('menus', $menus);
        });

        // Admin & Member Sidebar Menus
        View::composer('admin.partials.sidebar', function ($view) {
            $admin_menus = Menu::active()
                ->admin()
                ->topLevel()
                ->with(['children' => function ($query) {
                    $query->active();
                }])
                ->get();

            $member_menus = Menu::active()
                ->member()
                ->topLevel()
                ->with(['children' => function ($query) {
                    $query->active();
                }])
                ->get();

            $view->with('admin_menus', $admin_menus);
            $view->with('member_menus', $member_menus);
        });
    }
}
