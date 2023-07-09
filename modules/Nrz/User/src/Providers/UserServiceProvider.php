<?php namespace Nrz\User\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use Nrz\User\Database\Seeders\UserSeeder;
use Nrz\User\Models\PersonalAccessToken;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
         $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        Route::middleware('api')
            ->group(__DIR__ . '/../Routes/routes.php');
        DatabaseSeeder::$seeders[] = UserSeeder::class;
    }

    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
