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

    $this->sendPushNotification(env('APP_NAME'),$request->message,$friend->device_token);

    return  $message;
   } 


   public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
}
