<?php namespace Nrz\Customer\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Route;
use Nrz\Customer\Database\Seeders\CustomerSeeder;

class CustomerServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
         $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        Route::middleware('api')
            ->group(__DIR__ . '/../Routes/routes.php');
        DatabaseSeeder::$seeders[] = CustomerSeeder::class;
    }

    public function boot()
    {

    }
}
