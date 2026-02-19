<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $site_setting = \App\Models\Setting::first();
                \Illuminate\Support\Facades\View::share('site_setting', $site_setting);

                // Dynamic Mail Config
                if ($site_setting) {
                    $config = [
                        'transport'  => $site_setting->mail_mailer ?? 'smtp',
                        'host'       => $site_setting->mail_host,
                        'port'       => $site_setting->mail_port,
                        'encryption' => $site_setting->mail_encryption,
                        'username'   => $site_setting->mail_username,
                        'password'   => $site_setting->mail_password,
                        'from'       => [
                            'address' => $site_setting->mail_from_address,
                            'name'    => $site_setting->mail_from_name,
                        ],
                    ];
                    config(['mail.mailers.smtp' => array_merge(config('mail.mailers.smtp'), $config)]);
                    config(['mail.from' => $config['from']]);
                }
            }
        } catch (\Exception $e) {
            // Silence error
        }

        \Illuminate\Pagination\Paginator::useBootstrapFour();
    }
}
