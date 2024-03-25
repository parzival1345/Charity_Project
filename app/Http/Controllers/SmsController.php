<?php

namespace App\Http\Controllers;

use App\Models\Save_code;
use App\Models\User;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sms_check(Request $request, $id)
    {
        $user_id = User::find($id)->id;
        $code = Save_code::find($user_id);
        if ($request->code != $code->one_time_password) {
            return response()->json([
                'status' => false,
                'message' => 'The entered code is not correct'
            ]);
        } else {
            $user = User::find($id);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            User::find($user)->update([
                'sms_confirmation' => 'yes'
            ]);
            return response()->json([
                'token' => $token,
                'status' => true,
                'message' => 'Account registered successfully'
            ]);
        }
    }
}
