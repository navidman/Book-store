<?php

namespace App\Providers;

use App\Facades\BookFacade;
use App\Facades\OrderFacade;
use App\Services\BookService;
use App\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        BookFacade::shouldProxyTo(BookService::class);
        OrderFacade::shouldProxyTo(OrderService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
