<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=FreebiesTableSeeder

class FreebiesTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_freebies')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
    
      $faker = Faker\Factory::create();

      $limit = 30;

      for ($i=0; $i < $limit; $i++) {
          # code...
          DB::table('library_freebies')->insert(
              [
                'code_freebies' => $faker->uuid,
                'title' => $faker->sentence,
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'day' => ($i+1),
                'cash' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                'coin' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                'score' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                'status' => 'enable',
              ]
          );
      }
    }
}
