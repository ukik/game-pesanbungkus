<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostMission extends Model
{
    protected $table = 'library_mission';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_mission',
      'title',
      'mode',
      'difficulty',
      'type',
      'package',
      'terrain',
      'tile',
      'cash',
      'coin',
      'score',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
