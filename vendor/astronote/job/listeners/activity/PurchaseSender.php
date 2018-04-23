<?php

use Sender;
use PurchaseEvent;
use App\Model\User\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PurchaseSender # implements ShouldQueue
{
    use InteractsWithQueue;
    
    public $connection = 'Activity';

    public function handle(PurchaseEvent $event)
    {
        $user = User::where('email', $event->target)->orWhere('phone',  $event->target)->first();
        $data = ['user' => $user, 'payload' => $event->payload[0]];

        try {
            echo $send = new Sender(message('url').'/game-activity-purchase.json', $data);       
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }            
    }
}
