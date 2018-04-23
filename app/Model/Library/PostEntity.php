<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostEntity extends Model
{
    protected $table = 'library_entity';

    protected $primaryKey = 'id';

    protected $fillable = [
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

}
