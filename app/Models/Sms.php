<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Session;
class Sms extends Model
{
    use HasFactory;
    protected $fillable = [
        "sender", "receiver", "msg", "session_id", "isClient"
    ];

    public static function getSession($isClient, $client_number) {
        if ($isClient && !Session::where("client_number", $client_number)->first()){
            return Session::create([
                "client_number" => $client_number
            ]);
        }
        else
        {
            return Session::where("client_number", $client_number)->first();
        }
    }

    public static function createSms($sms, $isClient): self{
        if ($isClient)
        {
            $session = self::getSession($isClient, $sms["sender"]);
        }
        else
        {
            $session = self::getSession($isClient, $sms["receiver"]);
        }
        return self::create([
            "sender" => $sms["sender"],
            "receiver" => $sms["receiver"],
            "msg" => $sms["msg"],
            "session_id" => $session->id,
            "isClient" => $isClient,
        ]);
    }
    public static function sendToClient($receiver, $sender, $body)
    {
         // Set the content-type to XML to send back TwiML from the PHP Helper Library
         header("content-type: text/xml");
         // message is the text to return to the user
         $response = new MessagingResponse();

         $response->message($receiver, $sender, $body);
         echo $response;
    }
}

