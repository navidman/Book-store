<?php

namespace App\Providers;

use App\Facades\AccountingFacade;
use App\Facades\AuthFacade;
use App\Facades\BookFacade;
use App\Facades\OrderFacade;
use App\Facades\PaymentFacade;
use App\Services\AccountingService;
use App\Services\AuthService;
use App\Services\BookService;
use App\Services\OrderService;
use App\Services\PaymentService;
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
        PaymentFacade::shouldProxyTo(PaymentService::class);
        AuthFacade::shouldProxyTo(AuthService::class);
        AccountingFacade::shouldProxyTo(AccountingService::class);
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
