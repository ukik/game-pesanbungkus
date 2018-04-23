<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=UsersProfileTableSeeder

use Faker\Provider\id_ID\PhoneNumber;
use Faker\Provider\id_ID\Address;

class UsersProfileTableSeeder extends Seeder
{

    public function run()
    {
      $faker = Faker\Factory::create();

      $user = DB::table('user')->pluck('code_user');
      $max = count($user)-1;

      for ($i=0; $i < count($user); $i++) {
          # code...
          DB::table('user_profile')->insert(
              [
                'code_profile' => $faker->uuid,
                'code_user' => $user[$i],
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->e164PhoneNumber,
                'address' => $faker->address,
              ]
          );
      }
    }
}
