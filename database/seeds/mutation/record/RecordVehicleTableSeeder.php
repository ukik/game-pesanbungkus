<?php

# php artisan db:seed --class=RecordVehicleTableSeeder

use App\Model\User\PostWallet;
use Illuminate\Database\Seeder;

class RecordVehicleTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mutation_record_vehicle')->truncate();
        //DB::table('user_wallet_income')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        function randomDay()
        {
            $startDate = new Carbon\Carbon('first day of January'); //date("Y-m-d 00:00:00");
            $endDate = new Carbon\Carbon("today");
            return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
        }

        $code = DB::table('user')->pluck('code_user');
        $data = DB::table('library_vehicle')->get();

        for ($h = 0; $h < count($code); $h++) {
            # code...
            $user = array_values(array($code[$h]))[0];

            for ($i = 0; $i < count($data); $i++) {

                $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                $endDate = new Carbon\Carbon("today");
                $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
                
                DB::table('mutation_record_vehicle')->insert(
                    [
                        'code_user' => $user,
                        'code_vehicle' => $data[$i]->code_vehicle,
                        'code_this' => $faker->uuid,                        
                        'package' => $data[$i]->package,
                        'title' => $data[$i]->title,
                        'level' => $data[$i]->level,
                        'name' => $data[$i]->name,
                        'description' => $data[$i]->description,
                        'cash' => $data[$i]->cash,
                        'coin' => $data[$i]->coin,
                        'discount' => $data[$i]->discount,
                        'health' => $data[$i]->health,
                        'fuel' => $data[$i]->fuel,
                        'created_at' => $randomDate,
                    ]
                );

                # UPDATE WALLET
                PostWallet::updateOrCreate(
                    [
                        # as index
                        'code_user' => $user,
                    ],
                    [
                        # as value
                        'code_wallet' => $faker->uuid,
                        'code_user' => $user,
                    ]
                );

                $source = DB::table('user_wallet')->where('code_user', $user);
                $source2 = DB::table('mutation_record_vehicle')->where('code_user', $user);

                $cash = ($user == $source->value('code_user') ? $source2->value('cash') : 0);
                $coin = ($user == $source->value('code_user') ? $source2->value('coin') : 0);
                
                $payload = [
                    'code_user' => $user,
                    'code_wallet' => $faker->uuid,
                    'code_user' => $user,
                    'activity' => $source->value('activity') + 1,
                    'cash_in' => 0,
                    'cash_out' => $source->value('cash_out') + $cash,
                    'coin_in' => 0,
                    'coin_out' => $source->value('coin_out') + $coin,
                ];

                PostWallet::updateOrCreate(
                    # can more than one using
                    # ['code_user' => $user, 'id' => 1],
                    ['code_user' => $user],
                    $payload
                );
            }
        }
    }
}
