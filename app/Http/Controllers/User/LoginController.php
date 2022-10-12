<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)

    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => ['required', 'string', "regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"]

        ]);
        if($validator->fails())
        {
            return response()->json([
                "errors"=>$validator->getMessageBag()
            ],422);
        }
        else
        {
            if (!Auth::attempt(['email' => $request->input("email"), 'password' =>  $request->input("password")])) {
                return response()->json([
                    "message" => "invalid Credentials",
    
                ], 401);
            } else {
                return response()->json([
                     Auth()->user(),
    
                ]);
            }

        }
       
    }
}
