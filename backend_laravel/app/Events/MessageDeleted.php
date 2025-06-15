<?php

namespace App\Events;

use App\Models\PremiereRoomMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $messageId;
    public string $roomCode;

    public function __construct(PremiereRoomMessage $message)
    {
        $this->messageId = $message->id;
        $this->roomCode = $message->premiere_room_code;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel("chat-room.{$this->roomCode}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.deleted';
    }
}
