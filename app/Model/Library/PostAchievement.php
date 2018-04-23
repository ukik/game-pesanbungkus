<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostAchievement extends Model
{
    protected $table = 'library_achievement';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_achievement',
      'title',
      'description',
      'category',
      'term',
      'label',
      'cash',
      'coin',
      'score',
      'target',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
