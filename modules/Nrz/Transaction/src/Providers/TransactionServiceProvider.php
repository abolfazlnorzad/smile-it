<?php namespace Nrz\Transaction\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Route;
use Nrz\Transaction\Database\Seeders\TransactionSeeder;

class TransactionServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
         $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        Route::middleware('api')
            ->group(__DIR__ . '/../Routes/routes.php');
        DatabaseSeeder::$seeders[]=TransactionSeeder::class;
    }

    public function boot()
    {

    }
}
