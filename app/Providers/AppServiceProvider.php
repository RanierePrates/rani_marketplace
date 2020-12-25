<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\ServiceProvider;
use PagSeguro\Library;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Library::initialize();
        Library::cmsVersion()->setName("Marketplace")->setRelease("1.0.0");
        Library::moduleVersion()->setName("Marketplace")->setRelease("1.0.0");
    }
}
