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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with('site_setting', \App\Models\Setting::first());
        });

        // Dynamic Mail Config
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailSetting = \App\Models\Setting::first();
                if ($mailSetting) {
                    $config = [
                        'transport'  => $mailSetting->mail_mailer ?? 'smtp',
                        'host'       => $mailSetting->mail_host,
                        'port'       => $mailSetting->mail_port,
                        'encryption' => $mailSetting->mail_encryption,
                        'username'   => $mailSetting->mail_username,
                        'password'   => $mailSetting->mail_password,
                        'from'       => [
                            'address' => $mailSetting->mail_from_address,
                            'name'    => $mailSetting->mail_from_name,
                        ],
                    ];
                    config(['mail.mailers.smtp' => array_merge(config('mail.mailers.smtp'), $config)]);
                    config(['mail.from' => $config['from']]);
                }
            }
        } catch (\Exception $e) {
            // Silence error if table doesn't exist yet during migration/setup
        }

        \Illuminate\Pagination\Paginator::useBootstrapFour();
    }
}
