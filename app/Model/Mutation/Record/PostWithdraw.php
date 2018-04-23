<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostWithdraw extends Model
{

    protected $table = 'mutation_record_withdraw';

    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_user',
      'code_withdraw',
      'code_this',
      'title',
      'label',
      'cash',
      'coin',
      'fee',
      'limit',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    public function getCashFeeAttribute()
    {
        return ($this->cash + ($this->cash * $this->fee));
    }    

    public function getCoinFeeAttribute()
    {
        return ($this->coin + ($this->coin * $this->coin));
    }    
    
}
