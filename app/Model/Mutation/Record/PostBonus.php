<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostBonus extends Model
{

    protected $table = 'mutation_record_bonus';
    
    protected $primaryKey = 'id';
   
    protected $fillable = [
      'id',
      'code_user','code_bonus',
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
