<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;



Route::get('/delivery-status', function (Request $request) {
    Log::info($request->all());
    dd($request->all());
});