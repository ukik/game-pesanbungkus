<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class GetSummary__x extends Model
{

    protected $table = 'user_summary';

    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $guarded = [
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

    protected $filter = [
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

    public static function initialize()
    {
      return [
        'code_summary' => '',
        'code_user' => '',
        'activity' => '',
        'cash_in' => '',
        'cash_out' => '',
        'coin_in' => '',
        'coin_out' => '',
        'score_in' => '',
        'created_at' => '',
        'updated_at' => '',        
      ];
    }        

    public function get_user_profile()
    {
        return $this->hasOne(User::class, 'code_user');
    }    
}
