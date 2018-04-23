<?php

use Sender;
use WithdrawEvent;
use App\Model\User\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawSender # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Activity';
    
    public function handle(WithdrawEvent $event)
    {
        $user = User::where('email', $event->target)->orWhere('phone',  $event->target)->first();
        $data = ['user' => $user, 'payload' => $event->payload[0]];

        try {
            echo $send = new Sender(message('url').'/game-activity-withdraw.json', $data);       
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }          
    }
}
