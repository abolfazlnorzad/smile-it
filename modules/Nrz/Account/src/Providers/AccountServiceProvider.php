<?php namespace Nrz\Account\Providers;

use Illuminate\Support\Facades\Route;

class AccountServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
         $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        Route::middleware('api')
            ->group(__DIR__ . '/../Routes/routes.php');
    }

    public function boot()
    {

    }
}