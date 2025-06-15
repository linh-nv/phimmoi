<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat-room.{roomCode}', function () {
    return true;
});
