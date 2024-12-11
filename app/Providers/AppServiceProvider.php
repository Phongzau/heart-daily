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
        $generalSettings = GeneralSetting::query()->first();
        // Biến toàn cục
        app()->singleton('generalSettings', function () use ($generalSettings) {
            return $generalSettings;
        });

        View::composer('*', function ($view) use ($generalSettings) {
            $carts = session()->get('cart', []);
            $logoSetting = LogoSetting::query()->first();
            $view->with([
                'logoSetting' => $logoSetting,
                'generalSettings' => $generalSettings,
                'carts' => $carts,
            ]);
        });

        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
