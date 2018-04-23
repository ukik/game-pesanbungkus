<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=EntityTableSeeder

class EntityTableSeeder extends Seeder
{

  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('library_entity')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    $faker = Faker\Factory::create();

    $initials = ['Vehicle1','Vehicle2','Vehicle3','Vehicle4','Bcoin','Bcash','Bhealth','Bfuel'];

    $difficulties = ['easy','medium','hard'];

    $code_entity = [
      '5ccd9fb4-8928-35fd-8cd6-8e267ab76fa1',
      '5ccd9fb4-8928-35fd-8cd6-8e267ab76fa2',
      '5ccd9fb4-8928-35fd-8cd6-8e267ab76fa3',
    ];//$faker->uuid;

    function GET (
      $data,
      $n1, $n2, $n3, $n4,
      $b1, $b2, $b3, $b4
    ){
      switch ($data) {
        case 'Vehicle1':
          return $n1;
          break;
        case 'Vehicle2':
          return $n2;
          break;
        case 'Vehicle3':
          return $n3;
          break;
        case 'Vehicle4':
          return $n4;
          break;
        case 'Bcoin':
          return $b1;
          break;
        case 'Bcash':
          return $b2;
          break;
        case 'Bhealth':
          return $b3;
          break;
        case 'Bfuel':
          return $b4;
          break;
      }
    }

    for ($j=0; $j < count($difficulties); $j++) {

      switch ($difficulties[$j]) {
        case 'easy':
          for ($i=0; $i < count($initials); $i++) {
            $form = [
              'code_entity' => $code_entity[0],
              'name' => $faker->text($maxNbChars = 50),
              'initial' => $initials[$i],
              'difficulty' => 'easy',
              'health' => GET($initials[$i], 5, 3, 3, 3, 1, 1, 1, 1), 
              'spawn' => GET($initials[$i], 0, 0, 2, 2, 2, 2, 2, 2),
              'premium' => GET($initials[$i], 0, 0, 0, 0, 15, 15, 1, 15), 
              'normal' => GET($initials[$i], 0, 0, 0, 0, 20, 0, 1, 15), 
              'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            ];
            DB::table('library_entity')->insert($form);  
          }
        break;
        case 'medium':
        for ($i=0; $i < count($initials); $i++) {
          $form = [
            'code_entity' => $code_entity[1],
            'name' => $faker->text($maxNbChars = 50),
            'initial' => $initials[$i],
            'difficulty' => 'medium',
            'health' => GET($initials[$i], 5, 3, 3, 3, 1, 1, 1, 1), 
            'spawn' => GET($initials[$i], 0, 2, 2, 2, 2, 2, 2, 2),
            'premium' => GET($initials[$i], 0, 0, 0, 0, 10, 10, 1, 10), 
            'normal' => GET($initials[$i], 0, 0, 0, 0, 20, 0, 1, 15), 
            'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
          ];
          DB::table('library_entity')->insert($form);  
        }
        break;
        case 'hard':
        for ($i=0; $i < count($initials); $i++) {
          $form = [
            'code_entity' => $code_entity[2],
            'name' => $faker->text($maxNbChars = 50),
            'initial' => $initials[$i],
            'difficulty' => 'hard',
            'health' => GET($initials[$i], 5, 3, 3, 3, 1, 1, 1, 1), 
            'spawn' => GET($initials[$i], 2, 2, 2, 2, 2, 2, 2, 2),
            'premium' => GET($initials[$i], 0, 0, 0, 0, 5, 5, 1, 5), 
            'normal' => GET($initials[$i], 0, 0, 0, 0, 20, 0, 1, 15), 
            'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
          ];
          DB::table('library_entity')->insert($form);  
        }
        break;
      }
    }
  }
}
