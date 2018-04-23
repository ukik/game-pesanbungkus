<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetVehicle extends Model
{
    protected $table = 'library_vehicle';

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $guarded = [
        'code_vehicle',
        'title',
        'package',
        'level',
        'name',
        'description',
        'cash',
        'coin',
        'discount',
        'health',
        'fuel',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id',
        'title',
        'package',
        'level',
        'name',
        'description',
        'cash',
        'coin',
        'discount',
        'health',
        'fuel',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function initialize()
    {
        return [
            'title' => '',
            'package' => '',
            'level' => '',
            'name' => '',
            'description' => '',
            'cash' => '',
            'coin' => '',
            'discount' => '',
            'health' => '',
            'fuel' => '',
            'status' => '',
            'created_at' => '',
            'updated_at' => '',
            'deleted_at' => '',
        ];
    }
   
    public function get_vehicle_meter()
    {
        return $this->hasOne(GetVehicleMeter::class, 'code_vehicle', 'code_vehicle')
          ->select(['code_vehicle','meter_power','meter_tank','meter_capacity']);
    }         

    // public function getCashAttribute()
    // {
    //     $data = $this
    //         ->hasOne(GetVehicle::class, 'code_vehicle', 'code_vehicle')
    //         ->select(\DB::raw('
    //             SUM(library_vehicle.cash - ((library_vehicle.cash*library_vehicle.discount)/100)) as cash_discount
    //         '))->value('cash_discount');

    //     return $data;
    // }

    // public function getCoinAttribute()
    // {
    //     $data = $this
    //         ->hasOne(GetVehicle::class, 'code_vehicle', 'code_vehicle')
    //         ->select(\DB::raw('
    //             SUM(library_vehicle.coin - ((library_vehicle.coin*library_vehicle.discount)/100)) as coin_discount
    //         '))->value('coin_discount');

    //     return $data;
    // }
    
}
