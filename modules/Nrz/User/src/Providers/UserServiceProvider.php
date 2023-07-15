<?php namespace Nrz\User\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Nrz\User\Contracts\UserProviderInterface;
use Nrz\User\Database\Repo\Mysql\MysqlUserProvider;
use Nrz\User\Database\Seeders\UserSeeder;

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
        $this->app->bindIf(UserProviderInterface::class , MysqlUserProvider::class);
    }
}
