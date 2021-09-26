<?php


// require_once "./../vendor/autoload.php";
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Twilio\TwiML\MessagingResponse;

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

Route::post('/listen',function(Request $request){
  // Set the content-type to XML to send back TwiML from the PHP Helper Library
  header("content-type: text/xml");
  // message is the text to return to the user
  $response = new MessagingResponse();
  $response->message(
      $request->Body
  );
  echo $response;
});
// both routes to register and login a user.
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login']);
// protected routes
Route::group(['middleware' => ['auth:sanctum']],function(){
  Route::post('/logout',[AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
