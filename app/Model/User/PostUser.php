<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class PostUser extends Model
{
    
    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
      'id',
      'code_user',
      'password',
      'remember_token',
      'name',
      'email',
      'address',
      'phone',
      'plain',
      'token',
      'refresh',
      'scope',
      'api',
      'claim',
      'protocol',
      'status',
      'created_at',
      'updated_at',
      'deleted_at'
    ];
    
    protected $table = 'user';
}
