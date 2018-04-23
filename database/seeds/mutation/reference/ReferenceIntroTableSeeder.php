<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=ReferenceIntroTableSeeder

class ReferenceIntroTableSeeder extends Seeder
{

    public function run()
    {
      $faker = Faker\Factory::create();

      $code_user = DB::table('user')->pluck('code_user');
      $code_intro = DB::table('library_intro')->pluck('code_intro');

      for ($h=0; $h < count($code_user); $h++) {
          # code...
          $user = array_values(array($code_user[$h]))[0];

          for ($i=0; $i < count($code_intro); $i++) {
              # code...
              DB::table('mutation_reference_intro')->insert(
                  [
                    'code_user' => $user,
                    'code_intro' => array_values(array($code_intro[$i]))[0],
                  ]
              );
          }
      }
    }
}
