<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=IntroTableSeeder

class IntroTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_intro')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
    
      $faker = Faker\Factory::create();

      $limit = 2;

      for ($i=0; $i < $limit; $i++) {
          # code...
          DB::table('library_intro')->insert(
              [
                'code_intro' => $faker->uuid,
                'title' => $faker->sentence,
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'variant' => array_values(['service','driver'])[$i],
                'status' => 'enable',
              ]
          );
      }
    }
}
