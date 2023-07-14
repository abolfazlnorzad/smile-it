<?php

// add your modules routes here
use Nrz\Transaction\Http\Controllers\TransactionController;

Route::middleware('auth:sanctum')->group(function ($router){
   $router->post('transaction',[TransactionController::class,"store"])->name('transaction.store');
});
