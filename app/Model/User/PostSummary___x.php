<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class PostSummary__x extends Model
{

    protected $table = 'user_summary';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_summary',
      'code_user',
      'activity',
      'cash_in',
      'cash_out',
      'coin_in',
      'coin_out',
      'score_in',
      'created_at',
      'updated_at',               
    ];

    protected $dates = ['deleted_at'];
}
