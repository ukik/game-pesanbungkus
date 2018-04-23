<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=HelpTableSeeder

use Carbon;

class HelpTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('library_help')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');      

        $faker = Faker\Factory::create();

        $key = ['pbpay','premium','cash','normal','coin','toko','kurir','pencapaian','jasa','leaderboard'];

        $title = ['PB-Pay','Premium','Cash','Normal','Coin','Toko','Kurir','Pencapaian','Jasa','Leaderboard'];

        for ($i=0; $i < count($key); $i++) {
            # code...
            DB::table('library_help')->insert(
                [
                    'code_help'     => $faker->uuid,
                    'title'         => $title[$i],
                    'key'           => $key[$i], 
                    'description'   => $faker->realText($maxNbChars = 500, $indexSize = 2),
                ]
            );
        }
    }
}
