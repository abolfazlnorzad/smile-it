<?php namespace Nrz\Transaction\Providers;

use Illuminate\Support\Facades\Route;

class TransactionServiceProvider extends \Illuminate\Support\ServiceProvider
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
