<?php

# php artisan db:seed --class=RecordAchievementTableSeeder

use App\Model\User\PostWallet;
use Illuminate\Database\Seeder;

class RecordAchievementTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mutation_record_achievement')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        $code_user = DB::table('user')->pluck('code_user');
        $code_achievement = DB::table('library_achievement')->get();

        // $max_user = count($code_user)-1;
        // $max_achievement = count($code_achievement)-1;

        for ($h = 0; $h < count($code_user); $h++) {
            # code...
            $user = array_values(array($code_user[$h]))[0];

            for ($i = 0; $i < count($code_achievement); $i++) {
                # code...

                $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                $endDate = new Carbon\Carbon("today");
                $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
                                
                DB::table('mutation_record_achievement')->insert(
                    [
                        'code_user' => $user,
                        'code_achievement' => $code_achievement[$i]->code_achievement,
                        'title' => $code_achievement[$i]->title,
                        'description' => $code_achievement[$i]->description,
                        'category' => $code_achievement[$i]->category,
                        'term' => $code_achievement[$i]->term,
                        'label' => $code_achievement[$i]->label,
                        'cash' => $code_achievement[$i]->cash,
                        'coin' => $code_achievement[$i]->coin,
                        'score' => $code_achievement[$i]->score,
                        # target is term: current/target
                        # example is cash_collected: 1000/50000
                        'target' => $code_achievement[$i]->target,
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
                $source2 = DB::table('mutation_record_achievement')->where('code_user', $user);

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
