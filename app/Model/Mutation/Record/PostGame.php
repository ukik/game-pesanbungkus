<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostGame extends Model
{

    protected $table = 'mutation_record_game';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_user',
      'code_game',
      'code_mission',
	    'code_tools_vehicle',
      'title',
      'premium',
      'normal',
      'star',
      'cash',
      'coin',
      'score',
      'overtime',
      'done',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];
}
