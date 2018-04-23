<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class GetUser extends Model
{
    
    protected $table = 'user';
    
    public $incrementing = false;

    protected $primaryKey = 'code_user';

    protected $hidden = [
        // 'password',
        // 'remember_token',
        // 'plain',
        // 'token',
        // 'refresh',
        // 'api',
        // 'claim',
        // 'protocol',
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
        'token',
        'api',
        'claim',
        'protocol',
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
