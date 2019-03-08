<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\User;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request) {

        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password'=> 'required|min:3',
        ]);

        $generateRandomString = Str::random(60);

        $token = hash('sha256', $generateRandomString);

        $user = new User();

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->api_token = $token;

        $user->save();

        return response()->json(['data' => ['user' => $user, 'token' => 'Bearer ' . $token]], 201);

    }
}
