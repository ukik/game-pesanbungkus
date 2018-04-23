<?php

use DB;

use App\Model\User\GetWallet;
use App\Model\Channel\ChanneHelperMutationToolsVehicle as GetToolsVehicle;

use App\Model\Mutation\Record\GetMission;
use App\Model\Library\GetMission as LibraryMission;

use App\Model\Mutation\Record\GetAchievement;
use App\Model\Library\GetAchievement as LibraryAchievement;

use App\Model\Channel\ChannelHelperLibraryAchievementBronze as LibraryAchievementBronze;
use App\Model\Channel\ChannelHelperLibraryAchievementSilver as LibraryAchievementSilver;
use App\Model\Channel\ChannelHelperLibraryAchievementGold as LibraryAchievementGold;

use App\Model\Mutation\Record\GetBonus;
use App\Model\Library\GetBonus as LibraryBonus;

use App\Model\Mutation\Record\GetFreebies;
use App\Model\Library\GetFreebies as LibraryFreebies;

use App\Model\Mutation\Record\GetTools;
use App\Model\Mutation\Record\PostTools;
use App\Model\Library\GetTools as LibraryTools;

use App\Model\Mutation\Record\GetVehicle;
use App\Model\Mutation\Record\PostVehicle;
use App\Model\Library\GetVehicle as LibraryVehicle;

use App\Model\Mutation\Record\GetWithdraw;
use App\Model\Library\GetWithdraw as LibraryWithdraw;

use App\Model\Mutation\Reference\GetIntro;
use App\Model\Library\GetIntro as LibraryIntro;

trait FilterAvailabilityUnion 
{

    private $value;

    # once transaction
    # if your requirement is insufficent then data would be rendered as false
    # if your requirement is sufficent then data would be rendered from library as true
    # suitable to list achievement on board
    # PENTING
    # -> fiturnya saya kunci hanya pada label = D dan category = bronze
    # -> dapat dibukan namun ada penyesuaian pada game "Achievement List"
    protected function AchievementAvailability($code_user){
        
        # if below parameters from library_achievement->term & user_wallet
        // cash_collected -> cash_in
        // coin_collected -> coin_in
        // score_collected -> score_in,
        // mission_completed -> premium+normal
        // premium_played -> premium,
        // normal_played -> normal,
        // star_a_collected -> star_a_in,
        // star_b_collected -> star_b_in,
        // star_c_collected -> star_c_in,
        // mission_failed -> failed,

        #$code_user = 'bf271059-f6d6-3bec-a322-d490bf319fe8';

        $wallet = GetWallet::where('code_user', '=', $code_user)->first();

        $library = LibraryAchievementBronze::class; //LibraryAchievement::class; 

        $mutation = GetAchievement::class;
        
        // data library yang muncul disini sudah bisa diclaim oleh user bersangkutan
        $query_library = $library::
            select(DB::raw('
                code_achievement,title,description,category,term,label,cash,coin,score,target,status,"" as available
                #, CONCAT(term, "-", id) as collection
            '))
            ->whereIn('label', ['D'])
            ->whereRaw('(target <= ? and term = "cash_collected")', $wallet->cash_in)
            ->orWhereRaw('(target <= ? and term = "coin_collected")', $wallet->coin_in)      
            ->orWhereRaw('(target <= ? and term = "score_collected")', $wallet->score_in)     
            ->orWhereRaw('(target <= ? and term = "mission_completed")', ($wallet->premium+$wallet->normal))
            ->orWhereRaw('(target <= ? and term = "premium_played")', $wallet->premium)      
            ->orWhereRaw('(target <= ? and term = "normal_played")', $wallet->normal)      
            ->orWhereRaw('(target <= ? and term = "star_a_collected")', $wallet->star_a_in)  
            ->orWhereRaw('(target <= ? and term = "star_b_collected")', $wallet->star_b_in)   
            ->orWhereRaw('(target <= ? and term = "star_c_collected")', $wallet->star_c_in)
            ->orWhereRaw('(target <= ? and term = "star_collected")', ($wallet->star_a_in+$wallet->star_b_in+$wallet->star_c_in));
            
        // akan dilakukan check untuk memastikan jika user sudah pernah melakukan claim    
        // data yang muncul dari filter ini dianggap sudah melakukan claim    
        // untuk menampilkan list data yang sudah claim
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_achievement', $query_library->pluck('code_achievement'))
            ->pluck('code_achievement','label');   

        // belum diambil claim
        // data yang muncul disini dianggap belum melakukan claim (unclaimed) 
        // tapi sudah bisa claim
        $excluded_library = $query_library->
            select(DB::raw('code_achievement,title,description,category,term,label,cash,coin,score,target,status,"claim" as available'))
            // jika get_mutation_achievement == null maka belum diambil
            // jika get_mutation_achievement != null maka sudah diambil
            ->with(['get_mutation_achievement' => function($query) use ($code_user){
                return $query
                    ->whereIn('label', ['D'])
                    ->where('code_user', $code_user);
            }])
            // ->whereIn('label', ['D'])
            ->whereNotIn('code_achievement', $query_mutation);

        return $excluded_library->paginate(50);

        // sudah diambil claim    
        // data yang muncul disini sudah dianggap melakukan claimed dan tidak boleh lagi melakukan claim
        $included_library = $library::
            select(DB::raw('code_achievement,title,description,category,term,label,cash,coin,score,target,status,"claimed" as available'))
            ->with(['get_mutation_achievement' => function($query) use ($code_user){
                return $query
                    ->where('label', 'D')
                    ->where('code_user', $code_user);
            }])            
            ->where('label', 'D')
            ->whereIn('code_achievement', $query_mutation) 
            ->union($excluded_library);         

        return paginator($included_library->get(), 50);

    }

    # once transaction
    protected function BonusAvailability($code_user){
        
        #$code_user = 'bf271059-f6d6-3bec-a322-d490bf319fe8';

        $library = LibraryBonus::class; 
        
        $mutation = GetBonus::class;

        $query_library = $library::pluck('code_bonus');

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_bonus', $query_library)->pluck('code_bonus');   

        $included_library = $library::whereNotIn('code_bonus', $query_mutation)
            ->paginate(50);
        
        return $included_library;
    }
    
    # once transaction
    protected function IntroAvailability($code_user){
        
        #$code_user = 'bf271059-f6d6-3bec-a322-d490bf319fe8';

        $library = LibraryIntro::class; 
        
        $mutation = GetIntro::class;

        $query_library = $library::pluck('code_intro');

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_intro', $query_library)->pluck('code_intro');   

        $included_library = $library::whereNotIn('code_intro', $query_mutation)
            ->paginate(50);
        
        return $included_library;
    }

    # once daily transaction
    protected function FreebiesAvailability($code_user){
        
        #$code_user = 'bf271059-f6d6-3bec-a322-d490bf319fe8';

        $library = LibraryFreebies::class; 
        
        $mutation = GetFreebies::class;

        $query_library = $library::pluck('code_freebies');

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->where('claim', '=', Carbon\Carbon::now()->format('Y-m-d'))
            ->whereIn('code_freebies', $query_library)->pluck('code_freebies');   

        $included_library = $library::whereNotIn('code_freebies', $query_mutation)
            ->paginate(50);

        return $included_library;
    }    

    # once transaction can be overrided if neccessary
    protected function ToolsAvailability($code_user){

        #$code_user = '7ad1d8a8-edd1-3f6e-99bd-c693dd206915';
        
        $library = LibraryTools::class; 
        
        $mutation = GetTools::class;

        $wallet = GetWallet::where('code_user', '=', $code_user)->first();

        $query_library = $library::
            select(DB::raw('
                *, 
                sum(library_tools.cash - ((library_tools.cash*library_tools.discount)/100)) as cash, 
                sum(library_tools.coin - ((library_tools.coin*library_tools.discount)/100)) as coin 
            '))
            ->join(
                DB::raw('
                       (select 
                            code_user, 
                            code_tools 
                        from 
                            mutation_record_tools 
                        where 
                            code_user = "'.$code_user.'" 
                        group by id) as mutation_record_tools
                    '), function($join) {
                $join
                    ->on(
                        'mutation_record_tools.code_tools', '=', 'library_tools.code_tools' 
                    );    
            })
            ->where('library_tools.cash', '<=', $wallet->cash_in)
            ->where('library_tools.coin', '<=', $wallet->coin_in)
            ->orWhereRaw('
                mutation_record_tools.code_tools in (select code_tools from mutation_record_tools where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);            
        
        // $query_mutation = $mutation::
        //     where('code_user', $code_user)
        //     ->whereIn('code_tools', $query_library->pluck('code_tools'));   

        $included_library = $library::
            //whereRaw('level = (select max(`level`) from library_tools)')
            whereNotIn('code_tools', $query_library->pluck('code_tools'))
            ->groupBy(['package'])
            ->paginate(50);
            
        return $included_library;
    }

    # once transaction can be overrided if neccessary
    protected function VehicleAvailability($code_user){
        #$code_user = '7ad1d8a8-edd1-3f6e-99bd-c693dd206915';
        
        $library = LibraryVehicle::class; 
        
        $mutation = GetVehicle::class;

        $wallet = GetWallet::where('code_user', '=', $code_user)->first();

        $query_library = $library::
            select(DB::raw('
                *, 
                sum(library_vehicle.cash - ((library_vehicle.cash*library_vehicle.discount)/100)) as cash, 
                sum(library_vehicle.coin - ((library_vehicle.coin*library_vehicle.discount)/100)) as coin 
            '))
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
                        'mutation_record_vehicle.code_vehicle', '=', 'library_vehicle.code_vehicle' 
                    );    
            })
            ->where('library_vehicle.cash', '<=', $wallet->cash_in)
            ->where('library_vehicle.coin', '<=', $wallet->coin_in)
            ->orWhereRaw('
                mutation_record_vehicle.code_vehicle in (select code_vehicle from mutation_record_vehicle where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);            
        
        $included_library = $library::
            //whereRaw('level = (select max(`level`) from library_tools)')
            whereNotIn('code_vehicle', $query_library->pluck('code_vehicle'))
            ->groupBy(['package'])
            ->paginate(50);
            
        return $included_library;
    }

    protected function WithdrawAvailability($code_user){
        
        #$code_user = 'bf271059-f6d6-3bec-a322-d490bf319fe8';

        $library = LibraryWithdraw::class; 
        
        $mutation = GetWithdraw::class;

        $wallet = GetWallet::where('code_user', '=', $code_user)->first();

        $query_library = $library::
            select(DB::raw('
                *, 
                sum(cash + ((cash*fee)/100)) as cash, 
                sum(coin + ((coin*fee)/100)) as coin 
            '))
            ->where('cash', '<=', $wallet->cash_in)
            ->where('coin', '<=', $wallet->coin_in)
            ->whereIn('code_withdraw', $query_library)
            ->groupBy(['id']);            

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->where('limit', '=', Carbon\Carbon::now()->format('Y-m-d'))
            ->whereIn('code_withdraw', $query_library->pluck('code_withdraw'))->pluck('code_withdraw');   

        $included_library = $query_library
            ->whereNotIn('code_withdraw', $query_mutation)
            ->paginate(50);
            
        return $included_library;
    } 

    protected function MissionAvailability($code_user){
        // only premium

        #$code_user = '7ad1d8a8-edd1-3f6e-99bd-c693dd206915';

        $limit = DB::table('library_limit')->pluck('range','label');

        $mutation = GetMission::class;
        $library = LibraryMission::class;        
        $toolsvehicle = GetToolsVehicle::class;

        $difficulty = GetWallet::
            select(
                DB::raw(
                    '
                    *,
                    CASE WHEN cash_in < '.$limit['min'].' THEN "easy" 
                         WHEN cash_in BETWEEN '.$limit['min'].' AND '.$limit['max'].' THEN "medium"
                         WHEN cash_in > '.$limit['min'].' THEN "hard"   
                    END as difficulty
                    '
                )
            )
            ->where('code_user', '=', $code_user)->value('difficulty');

        $code_tools_vehicle = $toolsvehicle::pluck('code_tools_vehicle');
        
        $tools_vehicle = $toolsvehicle::
            select(
                DB::raw(
                    '
                    *,
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

        $group = [
            'mutation_record_mission.code_user',
            'mutation_record_mission.code_this',
            'mutation_record_mission.key_title',
            'mutation_record_mission.key_package',
            'mutation_record_mission.key_level',
        ];

        $query_mutation =$mutation::
            select(
                DB::raw("
                    #channel_helper_mutation_tools_vehicle.*,
                    #mutation_record_mission.*,

                    channel_helper_mutation_tools_vehicle.code_user,
                    channel_helper_mutation_tools_vehicle.code_tools_vehicle,           

                    mutation_record_mission.id,
                    mutation_record_mission.code_user,
                    mutation_record_mission.code_mission,
                    mutation_record_mission.code_entity,
                    mutation_record_mission.code_this,
                    mutation_record_mission.difficulty,
                    mutation_record_mission.normal,
                    mutation_record_mission.premium,
                    mutation_record_mission.date,
                    mutation_record_mission.mode,
                    mutation_record_mission.terrain,
                    mutation_record_mission.tile,
                    mutation_record_mission.key_title,
                    mutation_record_mission.key_package,
                    mutation_record_mission.key_level,
                    mutation_record_mission.code_tools_vehicle
                ")      
            )
            ->join(
                'channel_helper_mutation_tools_vehicle', function ($join) {
                    $join
                        ->on('channel_helper_mutation_tools_vehicle.code_this', '=', 'mutation_record_mission.code_this');
                }
            )
            ->where('mutation_record_mission.difficulty', '=', $difficulty) // only premium
            ->where('mutation_record_mission.normal', '=', NULL) // only premium
            ->where('mutation_record_mission.premium', '!=', NULL) // only premium
            ->where('mutation_record_mission.date', '=', Carbon\Carbon::now()->format('Y-m-d'))
            ->where('mutation_record_mission.code_user', '=', $code_user)
            ->where('channel_helper_mutation_tools_vehicle.code_user', '=', $code_user)
            ->whereIn('mutation_record_mission.code_tools_vehicle', $code_tools_vehicle)   
            ->whereIn('channel_helper_mutation_tools_vehicle.code_tools_vehicle', $code_tools_vehicle)   
            ->whereIn('mutation_record_mission.key_level',$tools_vehicle)
            ->groupBy($group)
            ->orderBy('mutation_record_mission.id', 'asc');
    
        $key_package = $query_mutation->pluck('key_package');
        $mode = $query_mutation->pluck('mode');
        $terrain = $query_mutation->pluck('terrain');
        $tile = $query_mutation->pluck('tile');
        
        // this is list to select by player 'premium mission'
        // randomly will select only 1
        // list of availability will reduce as motorcycle,motorbox,taxi,pickup,artisan,cleaner,washer,service has been transfered to mutation_record_mission by today unique
        $data_library_mission = $library::
            select(DB::raw(
                '
                DISTINCT 
                    *, #mode, terrain, tile, package
                    code_mission,difficulty,terrain,tile,package
                '
            ))
            ->where('difficulty', $difficulty)
            ->whereNotIn('package', $key_package)
            ->whereNotIn('terrain', $terrain)
            ->whereNotIn('tile', $tile);
            //->get('code_mission','difficulty','terrain','tile','package');
                
        return $too = [
            $query_mutation->paginate(50),
            $data_library_mission->paginate(50)
        ];
    }
    
    protected function LeaderboardAvailability($code_user)
    {
        return GetWallet::with([
                'get_user_profile',
                'get_leaderboard'
            ])
            ->where('code_user', '=', $code_user)
            ->first();        
    }

    public function Availability($code_user)
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
                return $this->AchievementAvailability($code_user);
                break;
            case 'Bonus':
                # code...
                return $this->BonusAvailability($code_user);
                break;
            case 'Intro':
                # code...
                return $this->IntroAvailability($code_user);
                break;
            case 'Freebies':
                # code...
                return $this->FreebiesAvailability($code_user);
                break;
            case 'Tools':
                # code...
                return $this->ToolsAvailability($code_user);
                break;
            case 'Vehicle':
                # code...
                return $this->VehicleAvailability($code_user);
                break;
            case 'Withdraw':
                # code...
                return $this->WithdrawAvailability($code_user);
                break;
            case 'Mission':
                # code...
                return $this->MissionAvailability($code_user);
                break;
            case 'Leaderboard':
                # code...
                return $this->LeaderboardAvailability($code_user);
                break;
        }
    }
}