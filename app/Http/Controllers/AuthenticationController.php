<?php

namespace App\Http\Controllers;

use App\Events\Register;
use App\Events\SmsEvent;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\callback;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create([
            'first_name' => $request->f_name,
            'last_name' => $request->l_name,
            'phone_number' => $request->p_number,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'status' => 'accept'
        ]);
        return response()->json([
            'status' => true,
            'message' => 'register process working well'
        ]);
    }

    public function sms(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->f_name,
            'last_name' => $request->l_name,
            'phone_number' => $request->p_number,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'sms_confirmation' => 'no'
        ]);
        event(new SmsEvent($user));
        return response()->json([
            'status' => true,
            'message' => 'sms send'
        ]);
    }

    public function confirmation_code()
    {

    }
}
