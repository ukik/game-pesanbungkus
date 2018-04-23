<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetTools extends Model
{    
    protected $table = 'library_tools';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_tools',
      'title',
      'package',
      'price',
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

    protected $filter = [
      'id', 
      'title',
      'package',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'discount',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title' => '',
        'package' => '',
        'level' => '',
        'name' => '',
        'description' => '',
        'cash' => '',
        'coin' => '',
        'discount' => '',
        'status' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
      ];
    }        
}
