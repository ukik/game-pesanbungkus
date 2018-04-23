<?php

# php artisan db:seed --class=RecordWithdrawTableSeeder

use App\Model\User\PostWallet;
use Illuminate\Database\Seeder;

class RecordWithdrawTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mutation_record_withdraw')->truncate();
        //DB::table('user_wallet_income')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        function randomDay()
        {
            $startDate = new Carbon\Carbon('first day of November'); //date("Y-m-d 00:00:00");
            $endDate = new Carbon\Carbon("today");
            return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
        }

        $code_user = DB::table('user')->select('code_user')->get();
        $code_withdraw = DB::table('library_withdraw')->get();

        foreach ($code_user as $key => $code_user) {
            # code...
            $user = $code_user->code_user;

            for ($i = 0; $i < count($code_withdraw); $i++) {
                # code...

                $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                $endDate = new Carbon\Carbon("today");
                $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
                
                DB::table('mutation_record_withdraw')->insert(
                    [
                        'code_this' => $faker->uuid,
                        'code_user' => $user,
                        'code_withdraw' => $code_withdraw[$i]->code_withdraw,
                        'title' => $code_withdraw[$i]->title,
                        'label' => $code_withdraw[$i]->label,
                        'cash' => $code_withdraw[$i]->cash,
                        'coin' => $code_withdraw[$i]->coin,
                        'fee' => $code_withdraw[$i]->fee,
                        'created_at' => $randomDate//randomDay(),
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
                $source2 = DB::table('mutation_record_withdraw')->where('code_user', $user);

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
