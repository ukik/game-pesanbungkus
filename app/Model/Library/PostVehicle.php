<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostVehicle extends Model
{
    protected $table = 'library_vehicle';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_vehicle',
      'title',
      'package',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'discount',
      'health',
      'fuel',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
