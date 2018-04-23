<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;

use App\Model\Mutation\Record\GetAchievement;

class ChannelHelperLibraryAchievementBronzeD extends Model
{
    protected $table = 'channel_helper_library_achievement_bronze_d';

    public $incrementing = false;

    protected $primaryKey = 'code_achievement';

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
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title' => '',
        'code_achievement' => '',
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
    
    public function get_mutation_achievement()
    {
        return $this
              ->belongsTo(GetAchievement::class, 'code_achievement', 'code_achievement')
              ->select(['id','code_user','code_achievement','category','term','label','status','created_at']);
    }       

}
