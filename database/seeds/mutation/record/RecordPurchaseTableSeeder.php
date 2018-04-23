<?php

# php artisan db:seed --class=RecordPurchaseTableSeeder

use App\Model\User\PostWallet;
use Illuminate\Database\Seeder;

class RecordPurchaseTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mutation_record_purchase')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        function randomDay()
        {
            $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
            $endDate = new Carbon\Carbon("today");
            return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
        }

        $code_user = DB::table('user')->pluck('code_user');

        $data_purchase = DB::table('library_purchase')->get();

        for ($h = 0; $h < count($code_user); $h++) {
            # code...
            $user = array_values(array($code_user[$h]))[0];

            for ($i = 0; $i < count($data_purchase); $i++) {

                $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                $endDate = new Carbon\Carbon("today");
                $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
                                    
                DB::table('mutation_record_purchase')->insert(
                    [
                        'code_this' => $faker->uuid,
                        'code_user' => $user,
                        'code_purchase' => $data_purchase[$i]->code_purchase,
                        'title' => $data_purchase[$i]->title,
                        'currency' => $data_purchase[$i]->currency,
                        'label' => $data_purchase[$i]->label,
                        'price' => $data_purchase[$i]->price,
                        'value' => $data_purchase[$i]->value,
                        'discount' => $data_purchase[$i]->discount,
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
                // PERLU HELPER untuk merubah currency: row -> column
                // TO BE CONTINUED....
                // PURCHASE TIDAK PUNYA CASH, COIN, dan SCORE
                // KARENA USER MEMBELI DENGAN UANG ASLI
                $payload = [
                    'code_user' => $user,
                    'code_wallet' => $faker->uuid,
                    'code_user' => $user,
                    'activity' => $source->value('activity') + 1,
                    'cash_in' => $source->value('cash_in'),
                    'cash_out' => 0,
                    'coin_in' => $source->value('coin_in'),
                    'coin_out' => 0,
                    'score_in' => $source->value('score_in'),
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
