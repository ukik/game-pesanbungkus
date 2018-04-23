<?php

use Illuminate\Http\Request;

use App\Model\User\PostUser;

use App\Model\User\PostSummary;

use App\Model\User\PostWallet;

use App\Model\Mutation\Record\PostAchievement;
//use App\Model\Library\GetAchievement as LibraryAchievement;
use App\Model\Channel\ChannelHelperLibraryAchievementBronzeD as LibraryAchievement;

use App\Model\Mutation\Record\PostTools;
use App\Model\Library\GetTools as LibraryTools;

use App\Model\Mutation\Record\PostVehicle;
use App\Model\Library\GetVehicle as LibraryVehicle;

use App\Model\Mutation\Record\PostWithdraw;
use App\Model\Library\GetWithdraw as LibraryWithdraw;

trait FilterEntry1
{
    protected function AchievementEntry($request)
    {
        $faker = Faker\Factory::create();

        // $library = LibraryAchievement::class;
        // $mutation = PostAchievement::class;

        $code_user = $request->user;
        $code_achievement = $request->code;

        // $query_library = $library::
        //     where('code_achievement', $code_achievement)
        //     ->first();

        // $checking = $mutation::
        //     where('code_user', $code_user)
        //     ->where('code_achievement', $code_achievement)
        //     ->value('code_achievement');

        $summary = PostSummary::where('code_user', '=', $code_user)->first();

        $library = LibraryAchievement::class; 

        $mutation = PostAchievement::class;
        
        // check ulang, benarkah user ini boleh claim?
        $query_library = $library::
            select(DB::raw('
                code_achievement,
                title,
                description,
                category,
                term,
                label,
                cash,
                coin,
                score,
                target,
                status,
                "" as available
            '))
            ->whereRaw('(target <= ? and term = "cash_collected")', $summary->cash_in)
            ->orWhereRaw('(target <= ? and term = "coin_collected")', $summary->coin_in)      
            ->orWhereRaw('(target <= ? and term = "score_collected")', $summary->score_in)     
            ->orWhereRaw('(target <= ? and term = "mission_completed")', $summary->mission_completed)
            ->orWhereRaw('(target <= ? and term = "premium_played")', $summary->premium)      
            ->orWhereRaw('(target <= ? and term = "normal_played")', $summary->normal)      
            ->orWhereRaw('(target <= ? and term = "star_a_collected")', $summary->star_a_in)  
            ->orWhereRaw('(target <= ? and term = "star_b_collected")', $summary->star_b_in)   
            ->orWhereRaw('(target <= ? and term = "star_c_collected")', $summary->star_c_in)
            ->orWhereRaw('(target <= ? and term = "star_collected")', $summary->star_collected);

            // ->whereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "cash_collected")', $summary->cash_in)
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "coin_collected")', $summary->coin_in)      
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "score_collected")', $summary->score_in)     
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "mission_completed")', $summary->mission_completed)
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "premium_played")', $summary->premium)      
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "normal_played")', $summary->normal)      
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "star_a_collected")', $summary->star_a_in)  
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "star_b_collected")', $summary->star_b_in)   
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "star_c_collected")', $summary->star_c_in)
            // ->orWhereRaw('(code_achievement = "'.$code_achievement.'" and target <= ? and term = "star_collected")', $summary->star_collected);

        // return $query_library->pluck('code_achievement');

        // jika hasilnya kosong maka boleh diisi
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_achievement', $query_library->pluck('code_achievement'))
            ->where('code_achievement', $code_achievement)
            ->pluck('code_achievement','label');   

        if(count($query_mutation) > 0 ){
            return [
                "info"              => "existed", 
                "term"              => null, 
                "code_achievement"  => null,
            ];        
        }

        // belum diambil claim
        // data yang muncul disini dianggap belum melakukan claim (unclaimed) 
        // tapi sudah bisa claim
        $enable_library = $query_library
            ->select(DB::raw('
                code_achievement,
                title,
                description,
                category,
                term,
                label,
                cash,
                coin,
                score,
                target,
                status
            '))
            // jika get_mutation_achievement == null maka belum diambil
            // jika get_mutation_achievement != null maka sudah diambil
            ->with(['get_mutation_achievement' => function($query) use ($code_user){
                return $query
                    //->whereIn('label', ['D'])
                    ->where('code_user', $code_user);
            }])
            ->whereNotIn('code_achievement', $query_mutation)
            ->get();

        return $enable_library;

        foreach ($enable_library as $key => $value) {
            if($value->code_achievement == $code_achievement){
                $mutation_query = $mutation::create(
                    [
                        'code_user'         => $code_user,
                        'code_achievement'  => $value->code_achievement,
                        'title'             => $value->title,
                        'description'       => $value->description,
                        'category'          => $value->category,
                        'term'              => $value->term,
                        'label'             => $value->label,
                        'cash'              => $value->cash,
                        'coin'              => $value->coin,
                        'score'             => $value->score,
                        'target'            => $value->target,
                    ]
                );

                return [
                    "info"              => "created", 
                    "term"              => $value->term, 
                    "code_achievement"  => $value->code_achievement
                ];
            }
        }

        return [
            "info"              => "nothing", 
            "term"              => null, 
            "code_achievement"  => null,
        ];
        
    }

    protected function ProfileEntry($request)
    {
        $mutation = PostUser::class;

        $code_user = $request->code_user;

        $mutation_query = $mutation::
            updateOrCreate(
			[
                'code_user' => $code_user            
            ],
            [
                'name'      => $request->name,
                'password'  => bcrypt($request->password),
                'plain'     => $request->password,
                'address'   => $request->address,
                'phone'     => $request->phone,
            ]
        );

        return [
            "info" => "created", 
            "profile" => PostUser::where('code_user', $code_user)->get()
        ];
    }

    protected function ToolsEntry($request)
    {
        $faker = Faker\Factory::create();
        
        $mutation = PostTools::class;
        $library = LibraryTools::class;

        $code_user = $request->user;
        $code_tools = $request->code;
        
        $query_library = $library::
            where('code_tools', $code_tools)
            ->first();

        // check dulu apakah item ini sudah dimiliki
        $checking = $mutation::where('code_user', $code_user)
            ->where('code_tools', $code_tools)
            ->value('code_tools');

        if($checking){
            return [
                "info" => "existed" 
            ];        
        }

        $mutation_query = $mutation::create(
            [
                'code_user'     => $code_user,
                'code_tools'    => $query_library->code_tools,
                'code_this'     => $faker->uuid,
                'package'       => $query_library->package,
                'title'         => $query_library->title,
                'level'         => $query_library->level,
                'name'          => $query_library->name,
                'description'   => $query_library->description,
                'cash'          => $query_library->cash,
                'coin'          => $query_library->coin,
                'discount'      => $query_library->discount,
                'health'        => $query_library->health,
                'fuel'          => $query_library->fuel,
                'status'        => $query_library->status,
            ]
        );

        return [
            "info" => "created",
        ];
    }

    protected function VehicleEntry($request)
    {
        $faker = Faker\Factory::create();
        
        $mutation = PostVehicle::class;
        $library = LibraryVehicle::class;

        $code_user = $request->user;
        $code_vehicle = $request->code;

        $max_level = $mutation::
            select(
                DB::raw(
                    '
                    code_user,
                    CASE WHEN sum(level) = (1) THEN 1
                            WHEN sum(level) = (1+2) THEN 2
                            WHEN sum(level) = (1+2+3) THEN 3
                            ELSE max(level)
                    END AS level
                    '
                )
            )
            ->where('code_user', $code_user)
            ->groupBy(['code_user','package'])
            ->pluck('level');     

        // melakukan checking apakah user sudah melakukan pembelian vehicle di table mutasi
        $query_library = $library::
            // menentukan total harga yang dibayar
            select(DB::raw('*'))
            ->join(
                DB::raw('
                       (select 
                            code_user, 
                            code_vehicle 
                        from 
                            mutation_record_vehicle 
                        where 
                            code_user = "'.$code_user.'" 
                        group by id) as mutation_record_vehicle
                    '), function($join) {
                $join
                    ->on(
                        'mutation_record_vehicle.code_vehicle', '=', 'channel_helper_library_vehicle.code_vehicle' 
                    );    
            })
            // ->where('cash_discount','<=', $wallet->cash_in)
            // ->where('coin_discount','<=', $wallet->coin_in)              
            ->whereRaw('
                mutation_record_vehicle.code_vehicle in (select code_vehicle from mutation_record_vehicle where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);       

        $query_library = $library::
            where('code_vehicle', $code_vehicle)
            ->first();

        // check dulu apakah item ini sudah dimiliki
        $checking = $mutation::where('code_user', $code_user)
            ->where('code_vehicle', $code_vehicle)
            ->value('code_vehicle');

        if($checking){
            return [
                "info" => "existed" 
            ];        
        }

        $mutation_query = $mutation::create(
            [
                'code_user'     => $code_user,
                'code_vehicle'  => $query_library->code_vehicle,
                'code_this'     => $faker->uuid,
                'package'       => $query_library->package,
                'title'         => $query_library->title,
                'level'         => $query_library->level,
                'name'          => $query_library->name,
                'description'   => $query_library->description,
                'cash'          => $query_library->cash,
                'coin'          => $query_library->coin,
                'discount'      => $query_library->discount,
                'health'        => $query_library->health,
                'fuel'          => $query_library->fuel,
            ]
        );

        return [
            "info" => "created",
        ];
    }

    protected function WithdrawEntry($request)
    {
        $faker = Faker\Factory::create();
        
        $code_user = $request->user;
        $code_withdraw = $request->code;

        $library = LibraryWithdraw::class; 
        
        $mutation = PostWithdraw::class;

        $wallet = PostWallet::where('code_user', '=', $code_user);
        
        $query_library = $library::
            where('cash', '<=', $wallet->first()->cash_in)
            ->where('coin', '<=', $wallet->first()->coin_in)
            ->where('code_withdraw', $code_withdraw)
            ->first();

        // dibatasi 1 hari sekali withdraw   
        // mengecek withdraw sudah pernah dilakukan belum hari ini
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->where('limit', '=', date('Y-m-d'))
            ->pluck('code_withdraw');
            // ->where('created_at', '>', date('Y-m-d 00:00:00'))
            // ->where('created_at', '<', date('Y-m-d 23:59:59'))

        if(count($query_mutation) > 0){
            return [
                "info" => "existed" 
            ];        
        }

        $_wallet = $wallet->first();
        $_wallet->cash_in = $query_library->cash_fee;
        $_wallet->cash_out = $query_library->cash_fee;
        $_wallet->coin_in = $query_library->coin_fee;
        $_wallet->coin_out = $query_library->coin_fee;
        $_wallet->update();

        $mutation_query = $mutation::create(
            [
                'code_user'     => $code_user,
                'code_withdraw' => $query_library->code_withdraw,
                'code_this'     => $faker->uuid,
                'title'         => $query_library->title,
                'label'         => $query_library->label,
                'cash'          => $query_library->cash,
                'coin'          => $query_library->coin,
                'fee'           => $query_library->fee,
                'limit'         => date('Y-m-d'),
                'status'        => 'enable',
            ]
        );

        return [
            "info" => "created",
        ];
    }    

    public function Entry(Request $request)
    {
        //K4%0A3%05%00 = key
        //%0B%0C%F7%CBO%0C%0F3%8A%0A7%CCI%CA%0B%B4%05%00 = Achievement
        //%0B%CC%B5%2CM%89%F0%B5%05%00 = Bonus
        //%0B%0E75H%CE%B5%B0%05%00 = Intro
        //%0B%CA%F3%CA%89%0A%F7%2A%88%8A%F0%B5%05%00 = Freebies
        //%0Bs%B7%2CK%F2%F0%B5%05%00 = Tools
        //%0B%CB%0D%CBO%0C%F7%2B%8E%0A%B4%B5%05%00 = Vehicle
        //%0B3%CA1Ht%0F%AA%8C%8CH%B6%05%00 = Withdraw
        //%0B%09%CF%A9J6%CA%29KJ%B7%B5%05%00 = Mission
        //%0Bq%0F%CB%88r%0F%AB%8C%CC%B5%CCH%CE%0D%B4%05%00 = Leaderboard

        $key = [];
        
        for($i = 0; $i < count(getter('request')); $i++)
        {
            $key += [decode_key(getter('request'), $i ) => decode_value(getter('request'), $i)];
        }   

        switch ($key['key']) {
            case 'Achievement':
                # code...
                return $this->AchievementEntry($request);
                break;
            case 'Profile':
                # code...
                return $this->ProfileEntry($request);
                break;   
            case 'Tools':
                # code...
                return $this->ToolsEntry($request);
                break;
            case 'Vehicle':
                # code...
                return $this->VehicleEntry($request);
                break;                             
            case 'Withdraw':
                # code...
                return $this->WithdrawEntry($request);
                break;                             
        }        
    }
}
