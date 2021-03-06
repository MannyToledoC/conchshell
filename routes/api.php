<?php


// require_once "./../vendor/autoload.php";
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Twilio\TwiML\MessagingResponse;
use App\Http\Controllers\SmsController;

use App\Http\Controllers\AuthController;

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

Route::post('/listen',[SmsController::class, 'listen']);
Route::post('/send',[SmsController::class, 'send']);
// both routes to register and login a user.
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login']);
// protected routes
Route::group(['middleware' => ['auth:sanctum']],function(){
  Route::post('/logout',[AuthController::class, 'logout']);
});

Route::post('/test',[SmsController::class, 'store']);
Route::get('/sms',[SmsController::class, 'index']);


