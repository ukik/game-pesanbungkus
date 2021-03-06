<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\User;

class GetTools extends Model
{    
    protected $table = 'mutation_record_tools';
    
    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $guarded = [
      'id',  
      'code_user',
      'code_tools',
      'code_this',
      'package',
      'title',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'discount',
      'status',
      'created_at',            
      'updated_at',           
    ];

    protected $dates = ['deleted_at'];

    public function get_user_profile()
    {
        return $this->hasOne(User::class, 'code_user');
    }

    protected $filter = [
        'id',  
        'code_user',
        'code_tools',
        'code_this',
        'package',
        'title',
        'level',
        'name',
        'description',
        'cash',
        'coin',
        'discount',
        'status',
        'created_at',            
        'updated_at',      

        'get_user_profile.id',
        'get_user_profile.code_user',
        'get_user_profile.name',
        'get_user_profile.email',
        'get_user_profile.address',
        'get_user_profile.phone',
        'get_user_profile.scope',
        'get_user_profile.status',
        'get_user_profile.created_at',
        'get_user_profile.updated_at',               
    ];

    public static function initialize()
    {
      return [
        'id',  
        'code_user' => '',
        'code_tools' => '',
        'code_this' => '',
        'package' => '',
        'title' => '',
        'level' => '',
        'name' => '',
        'description' => '',
        'cash' => '',
        'coin' => '',
        'discount' => '',
        'status' => '',
        'created_at' => '',            
        'updated_at' => '',      

        'get_user_profile.id' => '',
        'get_user_profile.code_user' => '',
        'get_user_profile.name' => '',
        'get_user_profile.email' => '',
        'get_user_profile.address' => '',
        'get_user_profile.phone' => '',
        'get_user_profile.scope' => '',
        'get_user_profile.status' => '',
        'get_user_profile.created_at' => '',
        'get_user_profile.updated_at' => '',              
      ];
    }        
}
