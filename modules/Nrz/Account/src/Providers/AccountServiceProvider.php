<?php namespace Nrz\Account\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Route;
use Nrz\Account\Database\Seeders\AccountSeeder;

class AccountServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
         $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        Route::middleware('api')
            ->group(__DIR__ . '/../Routes/routes.php');
        DatabaseSeeder::$seeders[] = AccountSeeder::class;
    }

    public function boot()
    {

    }
}
