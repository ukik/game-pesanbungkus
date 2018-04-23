<?php

use ResetMissionEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetMissionListener # implements ShouldQueue
{
    use InteractsWithQueue;
    
    public function handle(ResetMissionEvent $event)
    {
       return ResetMission();
    }

}
