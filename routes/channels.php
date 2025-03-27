<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// only for live scores
Broadcast::channel('live-score', function () {
    return ['ably-capability' => ["subscribe", "publish"]];
});

// for universal use, just request a refresh of the page
Broadcast::channel('refresh-request', function () {
    return ['ably-capability' => ["subscribe", "publish"]];
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// the chat, all private but some more private
Broadcast::channel('chat.{roomId}', function (\App\Models\User $user, int $roomId) {
    Log::debug('from the channel.php');
    Log::debug($user->toJson());
    //$message = \App\Models\Chat\ChatMessage::find($messageId);
    if ($user->canJoinRoom($roomId)) {
        $room = \App\Models\Chat\ChatRoom::find($roomId);
        return [
            'id' => $user->id,
            'name' => $user->name,
            'users' => $room->users->toJson(),
            //'message' => $message->message,
            'ably-capability' => ["subscribe", "presence"]
        ];

    }
    return true;
    /*if ($room->private === false) {
        return $user->exists && $room->id === $message->room->id;
    }
    return $message->room->users->contains($user) && $room->id === $message->room->id;*/
});
