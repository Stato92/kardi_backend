<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('patients', function () {
    return \Illuminate\Support\Facades\Auth::check();
});
Broadcast::channel('patients.{id}', function () {
    return \Illuminate\Support\Facades\Auth::check();
});
Broadcast::channel('chat', function ($user) {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name,  'surname' => $user->surname];
    }
});
