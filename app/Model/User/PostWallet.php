<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class PostWallet extends Model
{

    protected $table = 'user_wallet';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_wallet',
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

    protected $hidden = [
      'created_at',
      'updated_at',
      'deleted_at'    
    ];    

    protected $appends = [
      'mission_completed',
      'star_collected',
    ];

    public function getMissionCompletedAttribute(){
      return $this->premium + $this->normal;  
    }
    
    public function getStarCollectedAttribute(){
      return $this->star_a_in + $this->star_b_in + $this->star_c_in;
    }    

    public function setCashInAttribute($value){
      $this->attributes['cash_in'] = $this->cash_in - $value;
    }

    public function setCashOutAttribute($value){
      $this->attributes['cash_out'] = $this->cash_out + $value;      
    }

    public function setCoinInAttribute($value){
      $this->attributes['coin_in'] = $this->coin_in - $value;      
    }

    public function setCoinOutAttribute($value){
      $this->attributes['coin_out'] = $this->coin_out + $value;      
    }

}
