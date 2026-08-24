<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['properties' => config('properties')]);
});
