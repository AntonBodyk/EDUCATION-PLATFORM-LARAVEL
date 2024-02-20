<?php

use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\PdfChannel;

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

Broadcast::channel('messages.{userId}', function (\App\Models\User $user, $userId) {
    return true;
});

Broadcast::channel('reportGeneration', PdfChannel::class);
