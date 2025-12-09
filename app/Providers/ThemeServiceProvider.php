<?php

namespace App\Providers;

use App\Services\GlobalDataResolver;
use Illuminate\Support\Facades\View;
use Roots\Acorn\Sage\SageServiceProvider;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton(GlobalDataResolver::class, GlobalDataResolver::class);

        View::share('globalDataResolver', $this->app->make(GlobalDataResolver::class));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
