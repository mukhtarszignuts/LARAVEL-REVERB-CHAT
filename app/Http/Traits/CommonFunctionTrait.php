<?php

namespace App\Http\Traits;

use Kreait\Firebase\Factory;
use Illuminate\Support\Carbon;
use Kreait\Firebase\Messaging\CloudMessage;

trait CommonFunctionTrait
{
    public function sendPushNotification($title,$msg,$device_token)
    {

        $token=$device_token;
        
        $firebase = (new Factory)
        
            ->withServiceAccount(storage_path('app/vue-laravel-a0c98-firebase-adminsdk-n4p07-7a4595307d.json'));

        $messaging = $firebase->createMessaging();
        
        $message = CloudMessage::withTarget('TOKEN',$token)
            ->withNotification([
            'title' => $title,
            'body' => $msg,
            ]);

        $messaging->send($message);

        return response()->json(['message' => 'Push notification sent successfully']);
    }
}
