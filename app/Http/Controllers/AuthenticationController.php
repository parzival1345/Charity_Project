<?php

namespace App\Http\Controllers;

use App\Events\Register;
use App\Events\SmsEvent;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Save_code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

session_start();

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->f_name,
            'last_name' => $request->l_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'status' => 'accept',
            'sms_confirmation' => 'no'
        ]);
        event(new SmsEvent($user));
        return response()->json([
            'status' => true,
            'message' => 'sms send'
        ]);
    }

    public function login(LoginRequest $request ,$id)
    {
        $user = User::find($id);
        if ($request->phone_number != $user-> phone_number && $request->password != $user->password) {
            return response()->json([
                'status' => false,
                'message' => 'login process was failed'
            ]);
        }else
        {
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return response()->json([
                'token' => $token,
                'status' => true,
                'message' => 'you are login'
            ]);
        }
    }



}
