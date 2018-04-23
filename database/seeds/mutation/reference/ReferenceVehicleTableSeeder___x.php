<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=ReferenceVehicleTableSeeder

class ReferenceVehicleTableSeeder extends Seeder
{

    public function run()
    {
      $faker = Faker\Factory::create();

      $code_user = DB::table('user')->pluck('code_user');
      $code_vehicle = DB::table('library_vehicle')->pluck('code_vehicle');

      function randomDay (){
        $startDate = new Carbon\Carbon('first day of January'); //date("Y-m-d 00:00:00");
        $endDate = new Carbon\Carbon("today");        
        return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
      }      

      for ($h=0; $h < count($code_user); $h++) {
          # code...
          $user = array_values(array($code_user[$h]))[0];

          for ($i=0; $i < count($code_vehicle); $i++) {
              # code...
              DB::table('mutation_reference_vehicle')->insert(
                  [
                    'code_user' => $user,
                    'code_vehicle' => array_values(array($code_vehicle[$i]))[0],
                    'created_at' => randomDay ()
                  ]
              );
          }
      }
    }
}
