<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Notifications\Notifiable;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Laravel\Passport\HasApiTokens;

class User extends Model
{
    // use HasApiTokens, Notifiable;

    protected $table = 'user';
    
    public $incrementing = false;

    protected $primaryKey = 'code_user';

    protected $hidden = [
        'password',
        'password',
        'remember_token',
        'plain',
        'token',
        'refresh',
        'api',
        'claim',
        'protocol',
    ];

    protected $guarded = [
        'id',
        'plain',
        'code_user',
        'name',
        'email',
        'address',
        'phone',
        'scope',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id',
        'code_user',
        'name',
        'email',
        'address',
        'phone',
        'scope',
        'status',
        'created_at',
        'updated_at', 
    ];

    public static function initialize()
    {
        return [
            'id' => '',
            'code_user' => '',
            'name' => '',
            'email' => '',
            'address' => '',
            'phone' => '',
            'scope' => '',
            'status' => '',
            'created_at' => '',
            'updated_at' => '', 
        ];
    }        
}
