<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetIntro extends Model
{
    protected $table = 'library_intro';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_intro',
      'title',
      'description',
      'variant',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'title',
      'description',
      'variant',
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
        'variant' => '',
        'status' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
      ];
    }        
}
