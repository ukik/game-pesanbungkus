<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=UsersTableSeeder

class UsersTableSeeder extends Seeder
{

    public function run()
    {
      $faker = Faker\Factory::create();

      $limit = 5;

      static $password;

      for ($i=0; $i < $limit; $i++) {
          # code...
          DB::table('user')->insert(
              [
                'code_user' => $faker->uuid,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => $password ?: $password = bcrypt('secret'),
                'remember_token' => str_random(10),
                'address' => $faker->realText($maxNbChars = 50, $indexSize = 2),
                'phone' => $faker->phoneNumber,
                'plain' => 'secret',
                'status' => 'enable',
              ]
          );
      }
    }
}
