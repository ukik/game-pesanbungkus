<?php

use RegisterEvent;
use App\Model\User\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterEmail # implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Email';
    
    public function handle(RegisterEvent $event)
    {
        $data = User::where('email', $event->target)->orWhere('phone', $event->target)->first();
        // $data = User::where('id', 100)->first();

        setter('event', $event);
        setter('email', $data['email']);
        
        Mail::send('emails.register', ['user' => $data], function($message)
        {
            $event = getter('event');
            $message
                ->from(email())
                ->to($event->target, "Game Pesanbungkus > ".$user->name)
                ->subject($event->subject);
        });        
    }
}
