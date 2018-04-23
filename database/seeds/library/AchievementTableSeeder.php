<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=AchievementTableSeeder

class AchievementTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_achievement')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      

      $faker = Faker\Factory::create();

      $labels = ['A','B','C','D'];
      $categories = ['gold','silver','bronze'];
      $terms = [
          'cash_collected',
          'coin_collected',
          'score_collected',
          'mission_completed',
          'mission_failed',
          'premium_played',
          'normal_played',
          'star_a_collected',
          'star_b_collected',
          'star_c_collected',
          'star_collected',
      ];

      for ($g=0; $g < count($categories); $g++) {
        # code...
        $category = array_values(array($categories[$g]))[0];

        for ($h=0; $h < count($labels); $h++) {
          $label = array_values(array($labels[$h]))[0];
          # code...

          for ($i=0; $i < count($terms); $i++) {
              # code...
              DB::table('library_achievement')->insert(
                  [
                    'code_achievement' => $faker->uuid,
                    'title' => $faker->sentence,
                    'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                    'category' => $category,
                    'term' => $terms[$i],
                    'label' => $label,
                    'cash' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                    'coin' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                    'score' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                    # target is term: current/target
                    # example is cash_collected: 1000/50000
                    'target' => array_values([5,10,15,20,25,30,35,40,45,50])[mt_rand(0,9)],
                    'status' => 'enable',
                  ]
              );
          }
        }
      }
    }
}
