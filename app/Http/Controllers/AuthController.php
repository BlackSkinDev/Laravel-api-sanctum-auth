<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request)
    {

        if (!Auth::attempt($request->all())) {
            return $this->error("Credentials not match", Response::HTTP_UNAUTHORIZED);
        }

        return $this->success(
            ['token' => auth()->user()->createToken('API Token')->plainTextToken]
            ,'Login success',
            Response::HTTP_OK
        );
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }


}
