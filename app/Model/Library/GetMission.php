<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetMission extends Model
{
    protected $table = 'channel_helper_library_mission';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_mission',
      'title',
      'mode',
      'difficulty',
      'premium',
      'normal',
      'package',
      'terrain',
      'tile',
      'cash',
      'coin',
      'score',
      'timer',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = [
      'deleted_at',
      'timer'
    ];

    protected $filter = [
      'id', 
      'title',
      'mode',
      'difficulty',
      'premium',
      'normal',
      'package',
      'terrain',
      'tile',
      'cash',
      'coin',
      'score',
      'timer',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title'       => '',
        'mode'        => '',
        'difficulty'  => '',
        'premium'     => '',
        'normal'      => '',
        'package'     => '',
        'terrain'     => '',
        'tile'        => '',
        'cash'        => '',
        'coin'        => '',
        'score'       => '',
        'timer'       => '',
        'status'      => '',
        'created_at'  => '',
        'updated_at'  => '',
        'deleted_at'  => '',
      ];
    }        

    protected $appends = [
      'tile_data',
      'time_setting',
      'time_waiting',
    ];

    protected $hidden = [
      'tile',
      //'terrain',
    ];

    public function scopePremium($query, $premium){
      if($premium){
          return $query
              ->where('normal', '=', NULL) // only premium
              ->where('premium', '!=', NULL); // only premium
      }
      return $query
          ->where('normal', '!=', NULL) // only normal
          ->where('premium', '=', NULL); // only normal      
    }    

    public function getTileDataAttribute(){
      return array_values(['A','B','C','D'])[mt_rand(0,3)];
    }

    public function getTimeSettingAttribute(){
      $premium = getter('premium');
      $server_datetime = \Carbon\Carbon::now()->format('H:i:s');    
      if($premium){
        return date("H:i:s",strtotime($this->timer)) >= $server_datetime;
      }
      return true;
    }

    public function getTimeWaitingAttribute(){
      $premium = getter('premium');
      if($premium){
        $server_datetime = \Carbon\Carbon::now();    
        return round(Calculation_Now($server_datetime, $this->timer));
      }
      return 0;
    }
    
}
