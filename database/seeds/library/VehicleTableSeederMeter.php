<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=VehicleTableMeterSeeder

class VehicleTableMeterSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_vehicle_meter')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
        
      $faker = Faker\Factory::create();

      $data = DB::table('library_vehicle')->get();

      for ($i=0; $i < count($data); $i++) {
          # code...
            DB::table('library_vehicle_meter')->insert(
                [
                    'uuid' => $faker->uuid,
                    'code_vehicle' => $data[$i]->code_vehicle,
                    'title' => $data[$i]->title,
                    'meter_power' => mt_rand(0, 9)+1,
                    'meter_tank' => mt_rand(0, 9)+1,
                    'meter_capacity' => mt_rand(0, 9)+1,
                ]
            );
        }
    }
}