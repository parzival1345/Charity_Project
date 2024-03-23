<?php

namespace App\Listeners;

use App\Events\SmsEvent;
use App\Models\Save_code;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SmsListener
{
    /**
     * Handle the event.
     */
    public function handle(SmsEvent $event)
    {
        $url = 'https://console.melipayamak.com/api/send/otp/9bb73e7c68cd4cc1b22055065b0be6e4';
        $data = array('to' => $event->user->phone_number);
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
            'user_id' => $event->user->id,
            'phone_number' => $event->user->phone_number,
            'one_time_password' => $code->code
        ]);

        return $result;
    }
}
