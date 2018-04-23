<?php

# php artisan db:seed --class=RecordMissionTableSeeder

use App\Model\User\PostWallet;
use App\Model\Mutation\Record\PostMission;
use Illuminate\Database\Seeder;
use App\Model\User\GetWallet;
class RecordMissionTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('mutation_record_mission')->truncate();
        //DB::table('user_wallet_income')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        function randomDay()
        {
            $startDate = new Carbon\Carbon('first day of January'); //date("Y-m-d 00:00:00");
            $endDate = new Carbon\Carbon("today");
            return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
        }

        $users = DB::table('user')
            //->where('code_user', '238718b7-e5e8-3553-9ae1-8bdf504662e5')
            ->pluck('code_user');

        $data_mission_query = DB::table('channel_helper_library_mission')->where('premium', 'premium');
        
        $mode = array_values(['driver','service'])[mt_rand(0,1)];
        if($mode == 'driver'){
            $package = array_values(['motorcycle','motorbox','taxi','pickup'])[mt_rand(0,4)];
            $terrain = array_values(['city','forest','beach','highway'])[mt_rand(0,4)];
            $tile = array_values(['A','B','C','D'])[mt_rand(0,4)];
        }else{
            $package = array_values(['artisan','cleaner','washer','service'])[mt_rand(0,4)];
            $terrain = array_values(['artisan','cleaner','washer','service'])[mt_rand(0,4)];    
            $tile = array_values(['A','B','C','D'])[mt_rand(0,4)];            
        }

        $limit = DB::table('library_limit')->pluck('range','label');
        $difficulty = GetWallet::
        select(
            DB::raw(
                '
                #*,
                CASE WHEN cash_in < '.$limit['min'].' THEN "easy" 
                     WHEN cash_in BETWEEN '.$limit['min'].' AND '.$limit['max'].' THEN "medium"
                     WHEN cash_in > '.$limit['min'].' THEN "hard"   
                END as difficulty
                '
            )
        )
        ->where('code_user', '=', $users)->value('difficulty');


        $data_tools_vehicle = DB::table('channel_helper_mutation_tools_vehicle')
		->select(
			DB::raw(
				'
				*,
				CASE WHEN sum(level) = (1) THEN 1
					WHEN sum(level) = (1+2) THEN 2
					WHEN sum(level) = (1+2+3) THEN 3
					ELSE max(level)
				END AS `level`
				'
			)
		)
		->whereIn('code_user', $users)
        ->groupBy(['code_user','package','level'])
        ->get();
        //->get(['code_user','code_tools_vehicle','code_this']);
        

        $library_mission = DB::table('library_mission');
        $mutation_record_mission = DB::table('mutation_record_mission');
        $update_or_create = PostWallet::class;

        $data_mission = $data_mission_query->get();

        $STORAGE = [];

        for ($k=0; $k < count($data_tools_vehicle) ; $k++) { 
            # code...
            for ($i = 0; $i < count($users); $i++) {
                    # code...
                    $user = array_values(array($users[$i]))[0];
        
                    $code_user = $mutation_record_mission->where('code_user','=', $data_tools_vehicle[$k]->code_user)->value('code_user');
                    $code_this = $mutation_record_mission->where('code_this','=', $data_tools_vehicle[$k]->code_this)->value('code_this');
                    $premium = $mutation_record_mission->where('premium','=', 'premium')->value('premium');
                    $date = $mutation_record_mission->where('date','=', null)->value('date');
					
					$done = array_values(['complete','failed'])[mt_rand(0,1)];
                    
                    $difficulty = $library_mission->where('difficulty', $difficulty)->value('difficulty');

                    //dd($code_user.''.$code_this.''.$premium.''.$date.''.$difficulty);

                    $mode = array_values(['driver','service'])[mt_rand(0,1)];
                    if($mode == 'driver'){
                        $package = array_values(['motorcycle','motorbox','taxi','pickup'])[mt_rand(0,3)];
                        $terrain = array_values(['city','forest','beach','highway'])[mt_rand(0,3)];
                        $tile = array_values(['A','B','C','D'])[mt_rand(0,3)];
                    }else{
                        $package = array_values(['artisan','cleaner','washer','service'])[mt_rand(0,3)];
                        $terrain = array_values(['artisan','cleaner','washer','service'])[mt_rand(0,3)];    
                        $tile = array_values(['A','B','C','D'])[mt_rand(0,3)];            
                    }                        

                    # code...
                    $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                    $endDate = new Carbon\Carbon("today");
                    $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');


                    $data_library_mission = DB::table('library_mission')
                        ->where('mode', $mode)
                        ->where('package', $package)
                        ->where('terrain', $terrain)
                        ->where('tile', $tile);

                    if($code_user == null && $code_this == null && $premium == null && $date == null){

                        //dd($data_mission[0]->code_mission); 

                        $forms = 
                            [
								'uuid' => $faker->uuid,
                                'code_user' => $users[$i],
                                'code_mission' => $data_library_mission->value('code_mission'),
                                'code_entity' => $data_library_mission->value('code_entity'),
                                'code_tools_vehicle' => $data_tools_vehicle[$k]->code_tools_vehicle,
                                'code_this' => $data_tools_vehicle[$k]->code_this,
                                'date' => Carbon\Carbon::now()->format('Y-m-d'),
                                'title' => $data_library_mission->value('title'),
                                'mode' => $mode,
                                'difficulty' => $difficulty,
                                'premium' => $data_library_mission->value('type'),
                                'normal' => null,
                                'package' => $package,
                                'terrain' => $terrain,
                                'tile' => $tile,
                                'cash' => $done == 'complete' ? $data_library_mission->value('cash') : 0,
                                'coin' => $done == 'complete' ? $data_library_mission->value('coin') : 0,
                                'score' => $done == 'complete' ? $data_library_mission->value('score') : 0,
								'done' => $done,
                                'created_at' => $randomDate,
                                'key_title' => $data_tools_vehicle[$k]->title,
                                'key_package' => $package,
                                'key_level' => $data_tools_vehicle[$k]->level,
                                
                                // 'expired' => $data_mission[$m]->expired,
                            ];
                        $mutation_record_mission->insert(
                            $forms
                        );

                        $STORAGE += [$forms];


                        # UPDATE WALLET
                        $update_or_create::updateOrCreate(
                            [
                                # as index
                                'code_user' => $users[$i],
                            ],
                            [
                                # as value
                                'code_wallet' => $faker->uuid,
                                'code_user' => $users[$i],
                            ]
                        );

                        $source = DB::table('user_wallet')->where('code_user', $users[$i]);
                        $source2 = DB::table('mutation_record_mission')->where('code_user', $users[$i]);

                        $cash = ($users[$i] == $source->value('code_user') ? $source2->value('cash') : 0);
                        $coin = ($users[$i] == $source->value('code_user') ? $source2->value('coin') : 0);
                        $score = ($users[$i] == $source->value('code_user') ? $source2->value('score') : 0);
                        
                        $payload = [
                            'code_user' => $users[$i],
                            'code_wallet' => $faker->uuid,
                            'code_user' => $users[$i],
                            'activity' => $source->value('activity') + 1,
                            'cash_in' => $source->value('cash_in') + $cash,
                            'cash_out' => 0,
                            'coin_in' => $source->value('coin_in') + $coin,
                            'coin_out' => 0,
                            'score_in' => $source->value('score_in') + $score,
                        ];

                        $update_or_create::updateOrCreate(
                            # can more than one using
                            # ['code_user' => $user, 'id' => 1],
                            ['code_user' => $users[$i]],
                            $payload
                        );
                    }
                // for ($m=0; $m < count($data_mission); $m++) {                     
                // }

            }
        }
        //var_dump ($STORAGE);
    }
}
