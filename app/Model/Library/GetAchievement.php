<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

use App\Model\Mutation\Record\GetAchievement as MutationGetAchievement;

class GetAchievement extends Model
{
    protected $table = 'library_achievement';

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

    public function get_mutation_achievement()
    {
        return $this
              ->belongsTo(MutationGetAchievement::class, 'code_achievement', 'code_achievement')
              ->select(['id','code_user','code_achievement','category','term','label','status','created_at']);
    }       
    
}
