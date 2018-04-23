<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=ReferenceToolsTableSeeder

class ReferenceToolsTableSeeder extends Seeder
{

    public function run()
    {
      $faker = Faker\Factory::create();

      $code_user = DB::table('user')->pluck('code_user');
      $code_tools = DB::table('library_tools')->pluck('code_tools');

      function randomDay (){
        $startDate = new Carbon\Carbon('first day of January'); //date("Y-m-d 00:00:00");
        $endDate = new Carbon\Carbon("today");        
        return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
      }      

      // function getDataUser ($n) {
      //   $code_user = DB::table('user')->pluck('code_user');
      //   for ($i=0; $i < count($code_user) ; $i++) {
      //     # code...
      //     return $code_user[$n];
      //   }
      // }
      //
      // function getDataTools ($n) {
      //   $code_tools = DB::table('library_tools')->pluck('code_tools');
      //   for ($i=0; $i < count($code_user) ; $i++) {
      //     # code...
      //     return $code_tools[$n];
      //   }
      // }

      // $max_user = count($code_user)-1;
      // $max_tools = count($code_tools)-1;

      for ($h=0; $h < count($code_user); $h++) {
          # code...
          $user = array_values(array($code_user[$h]))[0];

          for ($i=0; $i < count($code_tools); $i++) {
              # code...
              DB::table('mutation_reference_tools')->insert(
                  [
                    'code_user' => $user,
                    'code_tools' => array_values(array($code_tools[$i]))[0],
                    'created_at' => randomDay ()
                  ]
              );
          }
      }
    }
}
