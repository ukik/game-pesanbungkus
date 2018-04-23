<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=PurchaseTableSeeder

class PurchaseTableSeeder extends Seeder
{

    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('library_purchase')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
        
      $faker = Faker\Factory::create();

      $data_currency = ['cash','coin'];
      $data_label = ['A','B','C','D'];

      for ($h=0; $h < count($data_currency); $h++) {
        # code...
        $currency = $data_currency[$h];

        if ($currency == "cash") {
          # code...
          for ($i=0; $i < count($data_label); $i++) {
              # code...
              DB::table('library_purchase')->insert(
                  [
                    'code_purchase' => $faker->uuid,
                    'headline' => $faker->sentence,
                    'currency' => 'cash',
                    'label' => $data_label[$i],
                    'price' => array_values([100000,75000,50000,25000])[$i],
                    'value' => array_values([100000,75000,50000,25000])[$i],
                    'discount' => mt_rand(0,100),
                    'status' => 'enable',
                  ]
              );
          }
        }

        if ($currency == "coin") {
          # code...
          for ($i=0; $i < count($data_label); $i++) {
              # code...
              DB::table('library_purchase')->insert(
                  [
                    'code_purchase' => $faker->uuid,
                    'headline' => $faker->sentence,
                    'currency' => 'coin',
                    'label' => $data_label[$i],
                    'price' => array_values([100000,75000,50000,25000])[$i],
                    'value' => array_values([100000,75000,50000,25000])[$i],
                    'discount' => mt_rand(0,100),
                    'status' => 'enable',
                  ]
              );
          }
        }
      }
    }
}
