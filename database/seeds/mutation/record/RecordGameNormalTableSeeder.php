<?php

# php artisan db:seed --class=RecordGameNormalTableSeeder

use App\Model\User\PostWallet;
use Illuminate\Database\Seeder;

class RecordGameNormalTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('mutation_record_game')->truncate();
        //DB::table('user_wallet_income')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        function randomDay()
        {
            $startDate = new Carbon\Carbon('first day of January'); //date("Y-m-d 00:00:00");
            $endDate = new Carbon\Carbon("today");
            return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
        }

        $code_user = DB::table('user')->select('code_user')->get();

        $code_mission = DB::table('library_mission')->get();

        $code_vehicle = DB::table('channel_helper_mutation_tools_vehicle')->select('code_tools_vehicle')->pluck('code_tools_vehicle');
        
        foreach ($code_user as $key => $code_user) {
            # code...
            $user = $code_user->code_user;

            for ($i = 0; $i < count($code_mission); $i++) {
                # code...

                $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                $endDate = new Carbon\Carbon("today");
                $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');

                $code_tools_vehicle = $code_vehicle[mt_rand(0, count($code_vehicle)-1)];
                if($code_tools_vehicle == null){
                    $code_tools_vehicle = $code_vehicle[mt_rand(0, count($code_vehicle)-1)];
                }

                DB::table('mutation_record_game')->insert(
                    [
                        'code_user' => $user,
                        'code_game' => $faker->uuid,
                        'code_mission' => $faker->uuid,
						'code_tools_vehicle' => $code_tools_vehicle,
                        'title' => $code_mission[$i]->title,
                        'premium' => null,
                        'normal' => 'normal',
                        'star' => array_values(['A', 'B', 'C', 'D'])[mt_rand(0, 3)],
                        'cash' => mt_rand(10, 50),
                        'coin' => mt_rand(50, 250),
                        'score' => mt_rand(100, 100),
                        'overtime' => mt_rand(0, 60),
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
                $source2 = DB::table('mutation_record_game')->where('code_user', $user);

                $cash = ($user == $source->value('code_user') ? $source2->value('cash') : 0);
                $coin = ($user == $source->value('code_user') ? $source2->value('coin') : 0);
                $score = ($user == $source->value('code_user') ? $source2->value('score') : 0);
                
                $payload = [
                    'code_user' => $user,
                    'code_wallet' => $faker->uuid,
                    'code_user' => $user,
                    'activity' => $source->value('activity') + 1,
                    'cash_in' => $source->value('cash_in') + $cash,
                    'cash_out' => 0,
                    'coin_in' => $source->value('coin_in') + $coin,
                    'coin_out' => 0,
                    'score_in' => $source->value('score_in') + $score,
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
