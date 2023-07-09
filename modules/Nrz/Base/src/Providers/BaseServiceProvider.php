<?php namespace Nrz\Base\Providers;

class BaseServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
         $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
         $this->loadRoutesFrom(__DIR__.'/../Routes/routes.php');
    }

    public function boot()
    {

    }
}
