<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    public function register(Request $request){

        // create object with user info and validates
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        // creates a new user with user model
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        // creates a new token 
        $token = $user->createToken('conchtoken')->plainTextToken;
        // Creates a new response with user model and token
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response,201);
    }

    public function login(Request $request){
        // Creates a user obj then validates
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        // find user with that email
        $user = User::where('email',$fields['email'])->first();
        // check if password for that email is correct
        if(!$user || !Hash::check($fields['password'],$user->password)){
            // return 401
            return response([
                'message' => 'Wrong Credentials'
            ],401);
        }
        // if corrent -> create a new token
        $token = $user->createToken('conchtoken')->plainTextToken;
        $response = [
            'user' => $user->name,
            'token' => $token,
        ];
        return response($response,201);


    }
    // logs out the currently authenticated user
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return[
            'message' => 'Logged out'
        ];
    }
}