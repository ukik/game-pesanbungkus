<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=MissionTableSeeder

class MissionTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_mission')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
      // $scene = DB::table('library_mission_scene')->pluck('code_scene');
      // $max = count($earn)-1;

      function getEntity ($_difficulty, $code_entity) {
        switch ($_difficulty) {
          case 'easy':
            return $code_entity[0]->code_entity;
            break;
          case 'medium':
            return $code_entity[1]->code_entity;
            break;
          case 'hard':
            return $code_entity[2]->code_entity;
            break;
        }
      }        

      function creation_service () {
        $faker = Faker\Factory::create();

        $tile = ['A','B','C','D'];
        $difficulty = ['easy','medium','hard'];
        $type = ['premium','normal'];
        $package = ['artisan','cleaner','washer','service'];
        $terrain = ['service','artisan','cleaner','washer'];
        $mode = ['service'];

        $code_entity = DB::table('library_entity')->select(DB::raw(
          'DISTINCT code_entity as code_entity'
        ))->get();

        for ($h=0; $h < count($tile); $h++) {
          # code...
          $_tile = $tile[$h];

          for ($i=0; $i < count($difficulty); $i++) {
            # code...
            $_difficulty = $difficulty[$i];

            for ($j=0; $j < count($type); $j++) {
              # code...
              $_type = $type[$j];

              for ($k=0; $k < count($package); $k++) {
                # code...
                $_package = $package[$k];

                for ($l=0; $l < count($terrain); $l++) {
                  # code...
                  $_terrain = $terrain[$l];

                  for ($m=0; $m < count($mode); $m++) {
                    # code...
                    DB::table('library_mission')->insert(
                        [
                          'code_mission' => $faker->uuid,
                          'code_entity' => getEntity($difficulty[$i], $code_entity),
                          'title' => ucfirst($_type)." ".ucfirst($_tile)." ".ucfirst($_difficulty)." ".ucfirst($_package)." ".ucfirst($_terrain)." ".ucfirst($mode[$m])." ",
                          'mode' => $mode[$m],
                          'difficulty' => $_difficulty,
                          'type' => $_type,
                          'package' => $_package,
                          'terrain' => $_terrain,
                          'tile' => $_tile,
                          'cash' => $_type == 'premium'? array_values([50,100,200,300,400,500])[mt_rand(0,5)] : 0,
                          'coin' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                          'score' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                          // 'expired' => date("Y-m-d H:i:s", strtotime("+1 day")),
                          'status' => 'enable',
                        ]
                    );
                  }
                }
              }
            }
          }
        }
      }


      function creation_driver () {
        $faker = Faker\Factory::create();

        $tile = ['A','B','C','D'];
        $difficulty = ['easy','medium','hard'];
        $type = ['premium','normal'];
        $package = ['motorcycle','motorbox','taxi','pickup'];
        $terrain = ['city','forest','beach','highway'];
        $mode = ['driver'];

        $code_entity = DB::table('library_entity')->select(DB::raw(
          'DISTINCT code_entity as code_entity'
        ))->get();

        for ($h=0; $h < count($tile); $h++) {
          # code...
          $_tile = $tile[$h];

          for ($i=0; $i < count($difficulty); $i++) {
            # code...
            $_difficulty = $difficulty[$i];

            for ($j=0; $j < count($type); $j++) {
              # code...
              $_type = $type[$j];

              for ($k=0; $k < count($package); $k++) {
                # code...
                $_package = $package[$k];

                for ($l=0; $l < count($terrain); $l++) {
                  # code...
                  $_terrain = $terrain[$l];

                  for ($m=0; $m < count($mode); $m++) {
                    # code...
                    DB::table('library_mission')->insert(
                        [
                          'code_mission' => $faker->uuid,
                          'code_entity' => getEntity($difficulty[$i], $code_entity),
                          'title' => ucfirst($_type)." ".ucfirst($_tile)." ".ucfirst($_difficulty)." ".ucfirst($_package)." ".ucfirst($_terrain)." ".ucfirst($mode[$m])." ",
                          'mode' => $mode[$m],
                          'difficulty' => $_difficulty,
                          'type' => $_type,
                          'package' => $_package,
                          'terrain' => $_terrain,
                          'tile' => $_tile,
                          'cash' => $_type == 'premium'? array_values([50,100,200,300,400,500])[mt_rand(0,5)] : 0,
                          'coin' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                          'score' => array_values([50,100,200,300,400,500])[mt_rand(0,5)],
                          // 'expired' => date("Y-m-d H:i:s", strtotime("+1 day")),
                          'status' => 'enable',
                        ]
                    );
                  }
                }
              }
            }
          }
        }
      }

      creation_driver();
      creation_service();

    }
}
