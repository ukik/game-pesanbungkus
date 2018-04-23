<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostMaintenance extends Model
{
    protected $table = 'mutation_record_maintenance';

    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_maintenance',
      'title',
      'due',
      'start',
      'finish',
      'description',
      'condition',
      'initial',
      'value',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];
}
