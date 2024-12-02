<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class UserStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $status;

    public function __construct($user)
    {
        $this->user_id = $user->id;
        $this->status = $user->is_online ? 'online' : 'offline';
    }

    public function broadcastOn()
    {
        return new Channel('user-status');
    }
}
