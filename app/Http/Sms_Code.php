<?php

namespace App\Http;

use App\Models\Save_code;
use App\Models\User;

class Sms_Code
{
    public function sms_register($user)
    {
        $url = 'https://console.melipayamak.com/api/send/otp/9bb73e7c68cd4cc1b22055065b0be6e4';
        $data = array('to' => $user->phone_number);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        $code = json_decode($result);
        curl_close($ch);
        Save_code::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number,
            'one_time_password' => $code->code,
            'expire_at' => now()->addMinute(2),
        ]);

        return $result;
    }
    public function sms_reset($phone)
    {
        $user = User::where('phone_number',$phone)->get();
        $url = 'https://console.melipayamak.com/api/send/otp/9bb73e7c68cd4cc1b22055065b0be6e4';
        $data = array('to' => $user[0]->phone_number);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        $code = json_decode($result);
        curl_close($ch);
        Save_code::create([
            'user_id' => $user[0]->id,
            'phone_number' => $user[0]->phone_number,
            'one_time_password' => $code->code,
            'expire_at' => now()->addMinute(2),
        ]);

        return $result;
    }
}
