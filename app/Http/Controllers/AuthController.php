<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request){
        if(!$token = auth()->attempt($request->only(['name','email','password']))) {
            return response()->json([
                'errors' => [
                    'email' => ['Record not found']
                ]
            ]);
        };

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token,
            ],
        ]);
    }
}
