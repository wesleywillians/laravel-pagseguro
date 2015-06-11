<?php

namespace LaravelPagseguro;

use Illuminate\Support\ServiceProvider;
use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\Environments\Production;
use PHPSC\PagSeguro\Environments\Sandbox;
use PHPSC\PagSeguro\Requests\Checkout\CheckoutService;

class LaravelPagseguroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . "/config/pagseguro.php" => config_path('pagseguro.php')]);
    }

    public function register()
    {
        if (config('pagseguro.environment') == "sandbox") {
            $this->app->bind('PagseguroEnv', function () {
                return new Sandbox();
            });
        } else {
            $this->app->bind('PagseguroEnv', function () {
                return new Production();
            });
        }

        $this->app->bind('PHPSC\PagSeguro\Credentials', function () {
            return new Credentials(
                config('pagseguro.email'),
                config('pagseguro.token'),
                $this->app->make('PagseguroEnv')
            );
        });

        $this->app->bind('PHPSC\PagSeguro\Requests\Checkout\CheckoutService', function () {
            return new CheckoutService($this->app->make('PHPSC\PagSeguro\Credentials'));
        });
    }
}