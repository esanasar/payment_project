<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    dd(1233);
    return $request->user();
})->middleware('auth:sanctum');
