<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=ToolsTableSeeder

class ToolsTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_tools')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
        
      $faker = Faker\Factory::create();
      $label = ['artisan','cleaner','washer','service'];
      $name = ['Pertukangan','Kebersihan','Pencucian','Pelayanan'];
      $level = [1,2,3];

      for ($i=0; $i < count($level); $i++) {
          # code...
          DB::table('library_tools')->insert(
              [
                'code_tools' => $faker->uuid,
                'package' => $label[0],
                'level' => $level[$i],
                'name' => $name[0],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$i],
                'coin' => array_values([25000,50000,75000])[$i],
                'discount' => mt_rand(5,15),
                'status' => 'enable',
              ]
        );
      }

      for ($j=0; $j < count($level); $j++) {
          # code...
          DB::table('library_tools')->insert(
              [
                'code_tools' => $faker->uuid,
                'package' => $label[1],
                'level' => $level[$j],
                'name' => $name[1],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$j],
                'coin' => array_values([25000,50000,75000])[$j],
                'discount' => mt_rand(5,15),
                'status' => 'enable',
              ]
          );
      }

      for ($k=0; $k < count($level); $k++) {
          # code...
          DB::table('library_tools')->insert(
              [
                'code_tools' => $faker->uuid,
                'package' => $label[2],
                'level' => $level[$k],
                'name' => $name[2],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$k],
                'coin' => array_values([25000,50000,75000])[$k],
                'discount' => mt_rand(5,15),
                'status' => 'enable',
              ]
          );
      }

      for ($l=0; $l < count($level); $l++) {
          # code...
          DB::table('library_tools')->insert(
              [
                'code_tools' => $faker->uuid,
                'package' => $label[3],
                'level' => $level[$l],
                'name' => $name[3],
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'cash' => array_values([25000,50000,75000])[$l],
                'coin' => array_values([25000,50000,75000])[$l],
                'discount' => mt_rand(5,15),
                'status' => 'enable',
              ]
          );
      }
    }
}
