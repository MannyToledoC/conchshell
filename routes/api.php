<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Goal is to send a text to a bot then have it return a respose
// problem is how do i send a text message to an API


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
