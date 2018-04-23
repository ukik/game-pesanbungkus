<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostMaintenance extends Model
{
    protected $table = 'library_maintenance';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_maintenance',
      'title',
      'due',
      'start',
      'finish',
      'description',
      'control',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
