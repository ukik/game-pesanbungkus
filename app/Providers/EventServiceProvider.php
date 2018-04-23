<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [

        'RegisterEvent' => [
            'RegisterSender',
            // 'RegisterEmail',
        ],
        'ForgetEvent' => [
            'ForgetSender',
            // 'ForgetEmail',
        ],

        'PurchaseEvent' => [
            'PurchaseSender',
            // 'PurchaseEmail',
        ],
        'WithdrawEvent' => [
            'WithdrawSender',
            // 'WithdrawEmail',
        ],

        'ResetEvent' => [
            'ResetSender',
        ],
        'LoginEvent' => [
            'LoginSender',
        ],

        'BonusEvent' => [
            'BonusSender',
        ],
        'FreebiesEvent' => [
            'FreebiesSender',
        ],
        'GameEvent' => [
            'GameSender',
        ],
        'MissionEvent' => [
            'MissionSender',
        ],
        'ToolsEvent' => [
            'ToolsSender',
        ],
        'VehicleEvent' => [
            'VehicleSender',
        ],

        'ResetMissionEvent' => [
            'ResetMissionListener',
        ]

        # GENERATOR
        # delete this when production
        // 'App\Events\Auth\Login' => [
        //     'App\Listeners\Auth\LoginSender',
        // ], 
        // 'App\Events\Auth\Reset' => [
        //     'App\Listeners\Auth\ResetSender',
        // ], 
        // 'App\Events\Email\ForgetEvent' => [
        //     'App\Listeners\Email\ForgetEmail',
        //     'App\Listeners\Email\ForgetSender',
        // ], 
        // 'App\Events\Email\PurchaseEvent' => [
        //     'App\Listeners\Email\PurchaseEmail',
        //     'App\Listeners\Email\PurchaseSender',
        // ], 
        // 'App\Events\Email\WithdrawEvent' => [
        //     'App\Listeners\Email\WithdrawEmail',
        //     'App\Listeners\Email\WithdrawSender',
        // ], 
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
