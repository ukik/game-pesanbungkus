<?php

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subject;
    public $target;
    
    public function __construct($target = null, $subject = "Game-Pesanbungkus Login Account")
    {
        $this->subject = $subject;
        $this->target = $target;
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-login-event');
    }
}
