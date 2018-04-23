<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetBonus extends Model
{
    protected $table = 'library_bonus';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_bonus',
      'title',
      'description',
      'claim',
      'cash',
      'coin',
      'score',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'title',
      'description',
      'claim',
      'cash',
      'coin',
      'score',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title' => '',
        'description' => '',
        'claim' => '',
        'cash' => '',
        'coin' => '',
        'score' => '',
        'status' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
      ];
    }        
}
