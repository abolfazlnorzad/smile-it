<?php

use Illuminate\Support\Facades\Route;
use Nrz\User\Http\Controllers\Auth\LoginController;

Route::middleware("guest")->group(function ($router){
    $router->post("/login",[LoginController::class , "login"])->name("login");
});
