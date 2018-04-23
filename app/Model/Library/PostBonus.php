<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostBonus extends Model
{
    protected $table = 'library_bonus';

    protected $primaryKey = 'id';

    protected $fillable = [
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
    
}
