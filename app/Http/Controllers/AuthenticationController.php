<?php

namespace App\Http\Controllers;

use App\Events\SmsEvent;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Sms_Code;
use App\Models\Save_code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $phone = new Sms_Code();
        $phone->sms_register($user);
        return response()->json([
            'status' => true,
            'message' => 'sms send'
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (User::where('phone_number', $request->phone_number)->first()) {
            if (!Auth::attempt($request->only('phone_number', 'password'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'login process was failed'
                ]);
            } else {
                $user = auth()->user();
                $token = $user->createToken("API TOKEN")->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'status' => true,
                    'message' => 'you are login'
                ]);
            }
        } else {
            return \response()->json([
                'status' => false,
                'message' => 'first register your account'
            ]);
        }
    }
    public function sms_register_check(Request $request, $id)
    {
        $code = Save_code::where('user_id' , $id)->first();
        if ($request->code != $code->one_time_password /**|| now() > $code->expire_at**/) {
            return response()->json([
                'status' => false,
                'message' => 'The entered code is not correct or code was expired'
            ]);
        } else {
            $user = User::find($id);
            Save_code::where('user_id',$id)->first()->delete();
            $token = $user->createToken("API TOKEN")->plainTextToken;
            User::find($id)->update([
                'sms_confirmation' => 'yes'
            ]);
            return response()->json([
                'token' => $token,
                'status' => true,
                'message' => 'Account registered successfully'
            ]);
        }
    }
    public function logout($id)
    {
        $user = User::find($id);
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json([
            'status' => true,
            'message' => 'you are logout from the site'
        ]);
    }

    public function update_information(Request $request)
    {
        User::update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email
        ]);
    }



}
