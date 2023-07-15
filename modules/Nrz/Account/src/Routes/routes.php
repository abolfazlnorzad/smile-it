<?php

// add your modules routes here
use Nrz\Account\Http\Controllers\AccountController;

Route::middleware("auth:sanctum")->prefix("account")->group(function ($router){
   $router->post("create",[AccountController::class,'create'])->name('account.create');
   $router->get("show/{account:account_number}",[AccountController::class,"show"])->name('account.show');
   $router->get("history/{account:account_number}",[AccountController::class,"history"])->name('account.history');
});
