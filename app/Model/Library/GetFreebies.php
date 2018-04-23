<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetFreebies extends Model
{
    protected $table = 'library_freebies';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_freebies',
      'title',
      'description',
      'day',
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
      'day',
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
        'day' => '',
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
