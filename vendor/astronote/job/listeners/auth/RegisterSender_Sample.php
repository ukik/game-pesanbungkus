<?php

use Sender;
use RegisterEvent;
use App\Model\User\User;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterSender_Sample implements ShouldQueue
{
    use InteractsWithQueue;

    public $connection = 'Queue-Medium';
    
    public function handle(RegisterEvent $event)
    {
        #$data = User::where('token', Getter('passport'))->first();
        $data = User::where('id', 100)->first();

        # How To Use
        // $firebase = new Firebase(); 
        // echo $firebase->send("parent", $data);
        
        # agar jalan $curl harus di echo
        try {
            echo $send = new Sender(message('url').'/game-auth-register.json', $data);       
            return 'success';
        } catch(Exception $e){
            return 'failed';
        }            

        # delay execution
        // $this->release(10);
        # repeatation by php never ending        
        // if ($this->attempts() > 5) {
        //     //code
        // }              
        # repeatation by artisan
        # php artisan queue:listen --tries=5

        # sebaiknya tidak ada repeat
    }
}
