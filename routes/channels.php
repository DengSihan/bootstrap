<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\User;

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

Broadcast::channel('users', function(User $user){
    return $user;
});

Broadcast::channel('users.{id}', function(User $user, String $id){
    return $id == $user->id;
});
