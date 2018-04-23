<?php

use Sender;
use ResetEvent;
use App\Model\User\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetSender # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Auth';
    
    public function handle(LoginEvent $event)
    {
        $data = User::where('email', $event->target)->orWhere('phone',  $event->target)->first();
        
        try {
            echo $send = new Sender(message('url').'/game-auth-reset.json', ['user' => $data]);       
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }          
    }
}
