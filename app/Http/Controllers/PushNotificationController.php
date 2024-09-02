<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class PushNotificationController extends Controller
{
    public function sendPushNotification()
    {
        $firebase = (new Factory)
        
            ->withServiceAccount(storage_path('app/vue-laravel-a0c98-firebase-adminsdk-n4p07-7a4595307d.json'));

        $messaging = $firebase->createMessaging();
       
        // dTl3RmsXrsRDxgYMCZ1luJ:APA91bF-m6UEl-7eOBOJVDzV13foZfTZJXkYR22SZSyu2z_WwN1jzZu7KqKCDMyxtwxoJdAb-LmcttUaiqmGamQ1zDNktxq5SlrhmMHvnQeK3uiG1zL97Ws6-RCvNduaZEvBaN6kw9Bh
        // f5oP07qKOZKn8BQJOTQEbW:APA91bGUdgxES5w1dpcuK8icBaSrEN0jg1eXv87nASmQsq2-yd4gJfnVQ06pAZoxgxzPJSR9x_9loVvG4nZ-4fz-IuZW0LndPzLVYz2JfwNWNh9JTQrB3-faOGF1Tc6pGUm7Epb7FDZ5
         $token = "f5oP07qKOZKn8BQJOTQEbW:APA91bGUdgxES5w1dpcuK8icBaSrEN0jg1eXv87nASmQsq2-yd4gJfnVQ06pAZoxgxzPJSR9x_9loVvG4nZ-4fz-IuZW0LndPzLVYz2JfwNWNh9JTQrB3-faOGF1Tc6pGUm7Epb7FDZ5";
        $message = CloudMessage::withTarget('TOKEN',$token)
            ->withNotification([
            'title' => 'Hello from Firebase!',
            'body' => 'This is a test notification.',
            ]);

        $messaging->send($message);

        return response()->json(['message' => 'Push notification sent successfully']);
    }
}
