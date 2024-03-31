<?php

namespace App\Http\Controllers;

use App\Events\SmsEvent;
use App\Http\Requests\Reset_passRequest;
use App\Http\Sms_Code;
use App\Models\Save_code;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Password_ManagerController extends Controller
{
    public function send_sms(Request $request)
    {
        $phone = $request->phone_number;
        if (isset($phone)) {
            $user = new Sms_Code();
            $user->sms_reset($phone);
            return response()->json([
                'status' => true,
                'message' => 'sms send'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Your phone_number does not exist'
            ]);
        }
    }

    public function check_sms(Request $request, $id)
    {
        $code = Save_code::where('user_id', $id);
        if ($request->code != $code->one_time_password) {
            $code->delete();
            return response()->json([
                'status' => false,
                'message' => 'The entered code is not correct'
            ]);
        }else {
            $code->delete();
            return response()->json([
                'status' => true,
                'message' => 'code is correct'
            ]);
        }
    }

    public function reset_password(Reset_passRequest $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'password' => Hash::make($request->new_pass)
        ]);
        return response()->json([
            'status' => true,
            'message' => 'password is change'
        ]);
    }
    public function repeat_code(Request $request)
    {
        $phone = $request->phone_number;
        $user = new Sms_Code();
        $user->sms_default($phone);
        return response()->json([
            'status' => true,
            'message' => 'code send'
        ]);
    }
}
