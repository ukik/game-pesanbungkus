<?php

namespace App\Model\Library;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class GetWithdraw extends Model
{  
    protected $table = 'library_withdraw';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_withdraw',
      'title',
      'label',
      'cash',
      'coin',
      'fee',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'title',
      'label',
      'cash',
      'coin',
      'fee',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title' => '',
        'label' => '',
        'cash' => '',
        'coin' => '',
        'fee' => '',
        'status' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
      ];
    }   

    protected $appends = [
      'cash_fee',
      'coin_fee'
    ];

    public function getCashFeeAttribute()
    {
        return ($this->cash + (($this->cash * $this->fee)/100));
    }    

    public function getCoinFeeAttribute()
    {
        return ($this->coin + (($this->coin * $this->fee)/100));
    }    

    public function achievement()
    {
        return $this->hasOne(App\Model\Mutation\Record\PostWithdraw::class, 'code_achievement', 'code_achievement');
    }
        
}
