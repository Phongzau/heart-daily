<?php

namespace App\Providers;

use App\Models\LogoSetting;
use App\Models\GeneralSetting; 
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $logoSetting = LogoSetting::query()->first();
            $generalSettings = GeneralSetting::query()->first();
            $view->with([
                'logoSetting' => $logoSetting,
                'generalSettings' => $generalSettings,
            ]);
        });

        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
