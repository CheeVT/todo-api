<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\User;

class UserController extends Controller
{
    public function register(Request $request) {
        
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = new User();
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->name = $request->input('name');

        $user->save();

        return $user;
    }

    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);        

        try {
            if(!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));

    }
}
