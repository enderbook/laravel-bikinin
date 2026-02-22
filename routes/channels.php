<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('Wk4FklC0eP.chat.{id_chat}', function ($user, $id_chat) {
    return $user->chats()->where('id_chat', $id_chat)->exists();
});







