<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Sms;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            "session" => Session::all(),
            "sms" => Sms::all()
        ];
        return response($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            "sender" => "string|required",
            "receiver" => "string|required",
            "msg" => "string|required",
            "isClient" => "boolean",
        ]);

        if ($fields['isClient'] == "1"
            || $fields['isClient'] == "true"
            || $fields['isClient'] == "True")
        {
            $isClient = true;
        }
        else if ($fields['isClient'] == "0"
                 || $fields['isClient'] == "false"
                 || $fields['isClient'] == "False")
        {
            $isClient = false;
        }
        else
        {
            $isClient = null;
        }

        $sms = Sms::createSms($fields, $isClient);
        $session = Session::find($sms->session_id);

        $response = [
            "session" => $session,
            "sms" => $sms,
        ];

        return response($response, 201);
    }

    public function listen(Request $request)
    {
        $fields = [
            "sender" => $request->From,
            "receiver" => $request->To,
            "msg" => $request->Body,
        ];

        $isClient = true;

        $sms = Sms::createSms($fields, $isClient);

         // Set the content-type to XML to send back TwiML from the PHP Helper Library
        header("content-type: text/xml");
        // message is the text to return to the user
        $response = new MessagingResponse();

        $response->message(
            $request->Body
        );
        echo $response;
    }

    public function send(Request $request)
    {
        Sms::sendToClient($request->receiver, $request->sender, $request->body);
        echo($request);
        echo("sent");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
