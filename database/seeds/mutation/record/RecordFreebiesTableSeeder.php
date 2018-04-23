<?php

# php artisan db:seed --class=RecordFreebiesTableSeeder

use App\Model\User\PostWallet;
use Illuminate\Database\Seeder;

class RecordFreebiesTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mutation_record_freebies')->truncate();
        //DB::table('user_wallet_income')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        $code_user = DB::table('user')->select('code_user')->get();
        $code_freebies = DB::table('library_freebies')->get();

        foreach ($code_user as $key => $code_user) {
            # code...
            $user = $code_user->code_user;

            for ($i = 0; $i < count($code_freebies); $i++) {
                # code...

                $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                $endDate = new Carbon\Carbon("today");
                $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
                
                DB::table('mutation_record_freebies')->insert(
                    [
                        'code_user' => $user,
                        'code_freebies' => $code_freebies[$i]->code_freebies,
                        'title' => $code_freebies[$i]->title,
                        'description' => $code_freebies[$i]->description,
                        'day' => $code_freebies[$i]->day,
                        'cash' => $code_freebies[$i]->cash,
                        'coin' => $code_freebies[$i]->coin,
                        'claim' => new \Carbon\Carbon("today"),
                        'score' => $code_freebies[$i]->score,
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
                $source2 = DB::table('mutation_record_freebies')->where('code_user', $user);

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
