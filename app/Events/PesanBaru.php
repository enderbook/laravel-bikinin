<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\PesanModel;


class PesanBaru
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pesan;

    public function __construct(PesanModel $pesan)
    {
        $this->pesan = $pesan;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->pesan->id_chat);
    }

    public function broadcastWith()
    {
        \Log::info($this->pesan); // Tambahin log untuk cek isi pesan

        return [
            'private_key' => 'Wk4FklC0eP',
            'channel_name' => 'chat.' . $this->pesan->id_chat,
            'id_user' => $this->pesan->id_user,
            'pesan' => $this->pesan->pesan,
            'time' => now()->format('H:i:s') 
        ];
    }
}
