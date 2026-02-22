<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\PesanModel;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $id_user;
    public $id_chat;
    public $pesan;


    public function __construct($user, $message)
    {
        $this->id_user = $id_user;
        $this->id_chat = $id_chat;
        $this->pesan = $pesan;
    }

    public function broadcastOn()
    {
        return new Channel('chat-room');
    }
}
