<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(Request $request)
    {
        $rules = array(
            'password' => 'required',
            'email' => 'required|email',
        );


        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return $this->error("Invalid credentials", Response::HTTP_BAD_REQUEST,['errors'=>$error->errors()->all()]);
        }

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
