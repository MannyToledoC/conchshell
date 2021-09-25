<?php


require_once "/vendor/autoload.php";
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Twilio\TwiML\MessagingResponse;

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

Route::get('/listen',function(){
  // Set the content-type to XML to send back TwiML from the PHP Helper Library
  header("content-type: text/xml");

  $response = new MessagingResponse();
  $response->message(
      "I'm using the Twilio PHP library to respond to this SMS!"
  );
  echo $response;
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
