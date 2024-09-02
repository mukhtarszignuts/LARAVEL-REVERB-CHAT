<?php

use App\Models\User;
use App\Events\MessageSent;
use App\Http\Controllers\ChatController;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Route;
use GGInnovative\Larafirebase\Facades\Larafirebase;
use App\Http\Controllers\PushNotificationController;

use App\Http\Traits\CommonFunctionTrait;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'users' => User::whereNot('id', auth()->id())->get()
    ]);
})->middleware(['auth'])->name('dashboard');

Route::get('/chat/{friend}', function (User $friend) {
    return view('chat', [
        'friend' => $friend
    ]);
})->middleware(['auth'])->name('chat');

Route::get('/messages/{friend}', function (User $friend) {
    return ChatMessage::query()
        ->where(function ($query) use ($friend) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $friend->id);
        })
        ->orWhere(function ($query) use ($friend) {
            $query->where('sender_id', $friend->id)
                ->where('receiver_id', auth()->id());
        })
       ->with(['sender', 'receiver'])
       ->orderBy('id', 'asc')
       ->get();
})->middleware(['auth']);

Route::post('/messages/{friend}',[ChatController::class, 'sendMessage']);

 Route::post('save-token',[ChatController::class, 'saveToken'])->name('save-token');

require __DIR__ . '/auth.php';
