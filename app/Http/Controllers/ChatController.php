<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Http\Traits\CommonFunctionTrait;

class ChatController extends Controller
{
    use CommonFunctionTrait;

   public function sendMessage( Request $request, User $friend){
    $message = ChatMessage::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $friend->id,
        'text' => $request->message
    ]);
    broadcast(new MessageSent($message));
    $ftoken = $friend->device_token??'f5oP07qKOZKn8BQJOTQEbW:APA91bHqSgeG5W3NJbYt5CBNOth0HqExSe_JC-WiCRrTBXLe-FYu0hMjmEp357-KZU3G52XacqGvnbusLnsfx8j2ZiFhNJbnlhS92_D6IGceC84GsMNgwbrCaXVl9RHES2IDrS42I_L8';
    $this->sendPushNotification(env('APP_NAME'),$request->message,$ftoken);

    return  $message;
   } 


   public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
}
