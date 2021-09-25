<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Courier\CourierClient;
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

Route::get("/products",function(){
    $courier = new CourierClient("https://api.courier.com/", "API-TOKEN");

    $result = $courier->sendNotification(
      "EBS36S5C7E4R5TNS764SBFQFAPK0",
      "f90c2c27-c804-45e9-ade3-f976c732a69c",
      NULL,
      (object) [
        'phone_number' => 000000000,
      ],
      (object) [
        'msg' => "Testing",
      ]
    );
    echo "In send";
    $messageId = $result->messageId;
    echo($messageId);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
