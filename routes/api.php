<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WebhookResponse;



// Route::any('/delivery-status', function (Request $request) {
//     Log::info($request->all());
//     return response()->json(['status'=>200]);
// });

Route::any('delivery-status', [WebhookResponse::class, 'resposeDataCall']);