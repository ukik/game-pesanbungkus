<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=LimitTableSeeder

class LimitTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_limit')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
        
      $faker = Faker\Factory::create();

      $range = ['7500','15000'];

      for ($i=0; $i < count($range); $i++) {
          # code...
          DB::table('library_limit')->insert(
              [
                'code_limit' => $faker->uuid,
                'range' => $range[$i],
              ]
          );
      }
    }
}
