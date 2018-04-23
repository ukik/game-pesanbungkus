<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=VehicleTableSeeder

class VehicleTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_vehicle')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
        
      $faker = Faker\Factory::create();

      $label = ['motorcycle','motorbox','taxi','pickup'];
      $name = ['Motor - Ojek','Motor Box - Kurir','Mobil - Taksi','Pickup - Ekspedisi'];
      $level = [1,2,3];
      $health = [3,4,5];
      $fuel = [100,125,150]; // seconds

      for ($i=0; $i < count($level); $i++) {
          # code...
          DB::table('library_vehicle')->insert(
              [
                'code_vehicle' => $faker->uuid,
                'package' => $label[0],
                'level' => $level[$i],
                'name' => $name[0],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$i],
                'coin' => array_values([25000,50000,75000])[$i],
                'discount' => mt_rand(5,15),
                'health' => $health[$i],
                'fuel' => $fuel[$i],
                'status' => 'enable',
              ]
        );
      }

      for ($j=0; $j < count($level); $j++) {
          # code...
          DB::table('library_vehicle')->insert(
              [
                'code_vehicle' => $faker->uuid,
                'package' => $label[1],
                'level' => $level[$j],
                'name' => $name[1],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$j],
                'coin' => array_values([25000,50000,75000])[$j],
                'discount' => mt_rand(5,15),
                'health' => $health[$j],
                'fuel' => $fuel[$j],
                'status' => 'enable',
              ]
          );
      }

      for ($k=0; $k < count($level); $k++) {
          # code...
          DB::table('library_vehicle')->insert(
              [
                'code_vehicle' => $faker->uuid,
                'package' => $label[2],
                'level' => $level[$k],
                'name' => $name[2],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$k],
                'coin' => array_values([25000,50000,75000])[$k],
                'discount' => mt_rand(5,15),
                'health' => $health[$k],
                'fuel' => $fuel[$k],
                'status' => 'enable',
              ]
          );
      }

      for ($l=0; $l < count($level); $l++) {
          # code...
          DB::table('library_vehicle')->insert(
              [
                'code_vehicle' => $faker->uuid,
                'package' => $label[3],
                'level' => $level[$l],
                'name' => $name[3],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$l],
                'coin' => array_values([25000,50000,75000])[$l],
                'discount' => mt_rand(5,15),
                'health' => $health[$l],
                'fuel' => $fuel[$l],
                'status' => 'enable',
              ]
          );
      }
    }
}
