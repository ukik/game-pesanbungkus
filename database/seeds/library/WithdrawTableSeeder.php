<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=WithdrawTableSeeder

class WithdrawTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_withdraw')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
        
      $faker = Faker\Factory::create();

      $label = array_values(['1','2','3','4','5','6','7']);
      $cash = [2500,5000,7500,10000,15000,20000,25000];

      for ($i=0; $i < count($label); $i++) {
          # code...
          DB::table('library_withdraw')->insert(
              [
                'code_withdraw' => $faker->uuid,
                'label' => $i+1,
                'cash' => $label[$i],
                'coin' => 1000,
                'fee' => 5,
                'status' => 'enable',
              ]
          );
      }
    }
}
