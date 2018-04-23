<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

# Passport
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $fillable = [
        'id',
        'name',
        'status',
        'password',
        'plain',
        'email',
        'address',
        'phone',
        'code_user',
        'remember_token',
        'token',
        'scope',
        'api',
        'claim',
        'protocol',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $table = 'user';
}


