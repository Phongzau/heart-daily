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
            $carts = session()->get('cart', []);
            $logoSetting = LogoSetting::query()->first();
            $generalSettings = GeneralSetting::query()->first();
            $view->with([
                'logoSetting' => $logoSetting,
                'generalSettings' => $generalSettings,
                'carts'=> $carts,
            ]);
        });

        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
