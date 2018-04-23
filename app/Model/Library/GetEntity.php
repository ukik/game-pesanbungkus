<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetEntity extends Model
{  
    protected $table = 'library_entity';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_entity',
      'name',
      'initial',
      'difficulty',
      'health',
      'spawn',
      'premium',
      'normal',
      'description',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'code_entity',
      'name',
      'initial',
      'difficulty',
      'health',
      'spawn',
      'premium',
      'normal',
      'description',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'code_entity' => '',
        'name' => '',
        'initial' => '',
        'difficulty' => '',
        'health' => '',
        'spawn' => '',
        'premium' => '',
        'normal' => '',
        'description' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
      ];
    }        
}
