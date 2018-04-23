<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;

class ChannelHelperLibraryAchievementGold extends Model
{
    protected $table = 'channel_helper_library_achievement_gold';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_achievement',
      'title',
      'description',
      'category',
      'term',
      'label',
      'cash',
      'coin',
      'score',
      'target',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'title',
      'description',
      'category',
      'term',
      'label',
      'cash',
      'coin',
      'score',
      'target',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title' => '',
        'description' => '',
        'category' => '',
        'term' => '',
        'label' => '',
        'cash' => '',
        'coin' => '',
        'score' => '',
        'target' => '',
        'status' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
      ];
    }    
}
