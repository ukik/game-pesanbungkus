<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class GetSummary extends Model
{

    protected $table = 'user_summary';

    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $fillable = [
      'id',
      'code_wallet',
      'code_user',
      'activity',
      'premium',
      'normal',
      'cash_in',
      'cash_out',
      'coin_in',
      'coin_out',
      'score_in',
      'star_a_in',
      'star_b_in',
      'star_c_in',
      'star_in',
      'created_at',
      'updated_at', 
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id',
      'code_wallet',
      'code_user',
      'activity',
      'premium',
      'normal',
      'cash_in',
      'cash_out',
      'coin_in',
      'coin_out',
      'score_in',
      'star_a_in',
      'star_b_in',
      'star_c_in',
      'star_in',
      'created_at',
      'updated_at',
      'deleted_at'    
    ];

    public static function initialize()
    {
      return [
        'id' => '',
        'code_wallet' => '',
        'code_user' => '',
        'activity' => '',
        'premium' => '',
        'normal' => '',
        'cash_in' => '',
        'cash_out' => '',
        'coin_in' => '',
        'coin_out' => '',
        'score_in' => '',
        'star_a_in' => '',
        'star_b_in' => '',
        'star_c_in' => '',
        'star_in' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',     
      ];
    }        

    #protected $visible = ['code_user', 'code_wallet'];

    protected $hidden = [
      'created_at',
      'updated_at',
      'deleted_at'    
    ];

    protected $appends = [
      'mission_completed',
      'star_collected',
    ];

    public function get_user_profile()
    {
        return $this
          ->hasOne(User::class, 'code_user')
          ->select(['code_user','name']);
    }    

    public function get_leaderboard()
    {
        return $this
          ->hasMany(GetSummary::class, 'self', 'self')
          ->with('get_user_profile')
          ->orderBy('score_in', 'desc')
          ->take(3);
    }

    public function getMissionCompletedAttribute(){
      return $this->premium + $this->normal;  
    }
    
    public function getStarCollectedAttribute(){
      return $this->star_a_in + $this->star_b_in + $this->star_c_in;
    }

}
