<?php

use Sender;
use BonusEvent;
use App\Model\User\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BonusSender # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Activity';
    
    public function handle(BonusEvent $event)
    {
        $user = User::where('email', $event->target)->orWhere('phone',  $event->target)->first();
        $data = ['user' => $user, 'payload' => $event->payload[0]];

        try {
            echo $send = new Sender(message('url').'/game-activity-bonus.json', $data);      
            // return ($data['payload']);
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }
    }
}