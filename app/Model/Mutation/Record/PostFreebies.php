<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostFreebies extends Model
{
  
    protected $table = 'mutation_record_freebies';

    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_user',
      'code_freebies',      
      'title',
      'description',
      'claim',
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
