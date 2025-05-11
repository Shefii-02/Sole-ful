<?php

namespace App\Providers;

use App\Models\Basket;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        //
        Blade::if('detect', function () {
            if (!empty($_SERVER['HTTP_USER_AGENT'])) {
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                if (preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis', $user_agent)) {
                    return true; // Output content for mobile
                }
            }
            return false; // Output content for desktop
        });

        Vite::prefetch(concurrency: 3);
        // View::share('pageTitle', '');
        // View::share('pageKeywords', '');
        // View::share('pageDescription', '');
        // View::share('ogImage', url('images/general/logo-dark.png'));

        // $offerAdvertisements = \App\Models\Advertisement::where('text','offer')->select('image','redirection')->get();
        // View::share('offerAdvertisements', $offerAdvertisements);

        // $productAdvertisements = \App\Models\Advertisement::where('text','product')->select('image','redirection')->get();
        // View::share('productAdvertisements', $productAdvertisements);

    }
}
