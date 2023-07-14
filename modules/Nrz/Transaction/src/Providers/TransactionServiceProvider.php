<?php namespace Nrz\Transaction\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Route;
use Nrz\Account\Contracts\HistoryProviderInterface;
use Nrz\Account\Database\Repo\Mysql\MysqlHistoryRepo;
use Nrz\Transaction\Contracts\CommissionProviderInterface;
use Nrz\Transaction\Contracts\TransactionProviderInterface;
use Nrz\Transaction\Database\Repo\Mysql\MysqlCommissionRepo;
use Nrz\Transaction\Database\Repo\Mysql\MysqlTransactionRepo;
use Nrz\Transaction\Database\Seeders\CommissionSeeder;
use Nrz\Transaction\Database\Seeders\TransactionSeeder;

class TransactionServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
         $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        Route::middleware('api')
            ->group(__DIR__ . '/../Routes/routes.php');
        DatabaseSeeder::$seeders[]=CommissionSeeder::class;
        $this->mergeConfigFrom(__DIR__."/../Config/commission.php",'commission');
        $this->app->bindIf(TransactionProviderInterface::class , MysqlTransactionRepo::class);
        $this->app->bindIf(CommissionProviderInterface::class , MysqlCommissionRepo::class);

    }

    public function boot()
    {

    }
}
