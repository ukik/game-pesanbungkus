<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostFreebies extends Model
{
    protected $table = 'library_freebies';

    protected $primaryKey = 'id';

    protected $fillable = [
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

}
