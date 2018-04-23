<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=BonusTableSeeder

use Carbon;

class BonusTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_bonus')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      

      $faker = Faker\Factory::create();

      $limit = 10;

      for ($i=0; $i < $limit; $i++) {
          # code...
          DB::table('library_bonus')->insert(
              [
                'code_bonus' => $faker->uuid,
                'title' => $faker->sentence(50),
                'description' => $faker->realText($maxNbChars = 50, $indexSize = 2),
                'claim' => Carbon\Carbon::now()->addDays($i)->format('Y-m-d'),
                'cash' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                'coin' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                'score' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                'status' => 'enable',
              ]
          );
      }
    }
}
