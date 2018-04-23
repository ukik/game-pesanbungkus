<?php

use DB;

use App\Model\User\GetUser;

use App\Model\User\GetSummary;

use App\Model\User\GetWallet;
use App\Model\Channel\ChanneHelperMutationToolsVehicle as GetToolsVehicle;

use App\Model\Mutation\Record\GetMission;
use App\Model\Library\GetMission as LibraryMission;

use App\Model\Mutation\Record\GetAchievement;
use App\Model\Channel\ChannelHelperLibraryAchievementBronzeD as LibraryAchievement;

use App\Model\Mutation\Record\GetBonus;
use App\Model\Library\GetBonus as LibraryBonus;

use App\Model\Mutation\Record\GetFreebies;
use App\Model\Library\GetFreebies as LibraryFreebies;

use App\Model\Mutation\Record\GetTools;
use App\Model\Mutation\Record\PostTools;
use App\Model\Library\GetTools as LibraryTools;
use App\Model\Channel\ChannelHelperLibraryTools as HelperLibraryTools;

use App\Model\Mutation\Record\GetVehicle;
use App\Model\Mutation\Record\PostVehicle;
use App\Model\Library\GetVehicle as LibraryVehicle;
use App\Model\Library\GetVehicleMeter;
use App\Model\Channel\ChannelHelperLibraryVehicle as HelperLibraryVehicle;

use App\Model\Mutation\Record\GetWithdraw;
use App\Model\Library\GetWithdraw as LibraryWithdraw;

use App\Model\Mutation\Reference\GetIntro;
use App\Model\Library\GetIntro as LibraryIntro;

use App\Model\Library\GetPurchase as GetPurchase;

use App\Model\Library\GetHelp as GetHelp;

trait FilterAvailability 
{

    private $value;

    # once transaction
    # if your requirement is insufficent then data would be rendered as false
    # if your requirement is sufficent then data would be rendered from library as true
    # suitable to list achievement on board
    # PENTING
    # -> fiturnya saya kunci hanya pada label = D dan category = bronze
    # -> dapat dibuka namun ada penyesuaian pada fitur game "Achievement"
    protected function AchievementAvailability($code_user){

        $wallet = GetSummary::where('code_user', '=', $code_user)->first();

        $library = LibraryAchievement::class; 

        $mutation = GetAchievement::class;
        
        // data library yang muncul disini sudah bisa diclaim oleh user bersangkutan
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
                #, CONCAT(term, "-", id) as collection
            '))
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
            ->whereNotIn('code_achievement', $query_mutation);

        setter('additional', $library::paginate(50));

        return $enable_library->paginate(50);

    }

    # once transaction
    protected function BonusAvailability($code_user){

        $library = LibraryBonus::class; 
        
        $mutation = GetBonus::class;

        $query_library = $library::pluck('code_bonus');

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_bonus', $query_library)
            ->pluck('code_bonus');   

        $enable_library = $library::
            whereNotIn('code_bonus', $query_mutation)
            ->paginate(50);
        
        return $enable_library;
    }
    
    # once transaction
    protected function IntroAvailability($code_user){

        $library = LibraryIntro::class; 
        
        $mutation = GetIntro::class;

        $query_library = $library::
            pluck('code_intro');

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_intro', $query_library)
            ->pluck('code_intro');   

        $enable_library = $library::
            whereNotIn('code_intro', $query_mutation)
            ->paginate(50);
        
        return $enable_library;
    }

    # once daily transaction
    protected function FreebiesAvailability($code_user){

        $library = LibraryFreebies::class; 
        
        $mutation = GetFreebies::class;

        $query_library = $library::
            pluck('code_freebies');

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->where('claim', '=', Carbon\Carbon::now()->format('Y-m-d'))
            ->whereIn('code_freebies', $query_library)->pluck('code_freebies');   

        $enable_library = $library::
            whereNotIn('code_freebies', $query_mutation)
            ->paginate(50);

        return $enable_library;
    }    

    protected function ProfileAvailability($code_user){
        
        $library = GetToolsVehicle::class;

        $user = GetUser::class;
        
        // untuk menampilkan vehicle/tools yang dimiliki
        $library_query = $library::
            select(
                DB::raw(
                    '
                    code_user,
                    code_tools_vehicle,
                    code_this,
                    package,
                    title,
                    level,
                    name,
                    CASE WHEN sum(level) = (1) THEN 1
                            WHEN sum(level) = (1+2) THEN 2
                            WHEN sum(level) = (1+2+3) THEN 3
                            ELSE max(level)
                    END AS level
                    '
                )
            )
            ->with('get_vehicle_meter')
            ->where('code_user', $code_user)
            ->groupBy(['code_user','package']);

        $user_query = $user::where('code_user', $code_user)
            ->select(['code_user','name','plain','address','phone','email'])
            ->first();
        
        setter('additional', $user_query);

        return $library_query->paginate(50);
    }

    # once transaction can be overrided if neccessary
    protected function ToolsAvailability($code_user){
        
        $library = HelperLibraryTools::class; //LibraryTools::class; 
        
        $mutation = GetTools::class;

        $wallet = GetWallet::
            where('code_user', '=', $code_user)
            ->first();

        $max_level = $mutation::
            select(
                DB::raw(
                    '
                    code_user,
                    level,
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

        // melakukan checking apakah user sudah melakukan pembelian tools di table mutasi
        $query_library = $library::
            // menentukan total harga yang dibayar
            select(DB::raw('*'))
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
                        'mutation_record_tools.code_tools', '=', 'channel_helper_library_tools.code_tools' 
                    );    
            })
            // memastikan pembatasan list tools yang dimunculkan sesuai dengan pemiliknya di mutation_record_tools
            // ->orWhereRaw('
            ->whereRaw('
                mutation_record_tools.code_tools in (select code_tools from mutation_record_tools where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);       
        
        // memastikan jika data tools di library sudah dipindahkan ke mutasi
        // jika kosong berarti tidak ada lagi yang bisa dibeli/dimutasi
        // data yang muncul disini adalah yang bisa dibeli karena syaratnya cukup tapi belum dimutasi           
        $excluded_library = $library::
            select(DB::raw('
                *, 
                "tools" as type
            '))
            ->whereNotIn('code_tools', $query_library->pluck('code_tools'))
            //->select(['level','package'])
            ->groupBy(['package'])
            ->get();

        // Layer 1: pasang dulu di game
        $library_max = $library::
            select(DB::raw('
                *, 
                "tools" as type
            '))
            ->whereIn('level', $max_level)
            ->get();

        // Layer 2: akan mengganti data additional jika terdapat replacer
        $included_library = $library::
            select(DB::raw('
                *, 
                "tools" as type
            '))
            ->whereIn('code_tools', $query_library->pluck('code_tools'))
            ->get();    

        setter('additional', $wallet);

        // Layer 3: akan mengganti data additional jika terdapat replacer
        return [
            'layer1' => $library_max, 
            'layer2' => $included_library, 
            'layer3' => $excluded_library, 
        ];
    }

    # once transaction can be overrided if neccessary
    protected function VehicleAvailability($code_user){
        
        $library = HelperLibraryVehicle::class; //LibraryVehicle::class; 
        
        $mutation = GetVehicle::class;

        $wallet = GetWallet::
            where('code_user', '=', $code_user)
            ->first();

        $max_level = $mutation::
            select(
                DB::raw(
                    '
                    code_user,
                    level,
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
            ->whereRaw('
                mutation_record_vehicle.code_vehicle in (select code_vehicle from mutation_record_vehicle where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);       
        
        //return $query_library->pluck('level');

        // memastikan jika data vehicle di library sudah dipindahkan ke mutasi
        // jika kosong berarti tidak ada lagi yang bisa dibeli/dimutasi
        // data yang muncul disini adalah yang bisa dibeli karena syaratnya cukup tapi belum dimutasi            
        $enable_library = $library::
            select(DB::raw('
                *, 
                "vehicle" as type
            '))
            ->whereNotIn('code_vehicle', $query_library->pluck('code_vehicle'))
            ->with('get_vehicle_meter')
            //->select(['level','package'])
            ->groupBy(['package'])
            ->get();

        // Layer 1: pasang dulu di game
        $library_max = $library::
            select(DB::raw('
                *, 
                "vehicle" as type
            '))
            ->with('get_vehicle_meter')
            ->whereIn('level', $max_level)
            ->get();

        // Layer 2: akan mengganti data additional jika terdapat replacer
        $disable_library = $library::
            select(DB::raw('
                *, 
                "vehicle" as type
            '))
            ->whereIn('code_vehicle', $query_library->pluck('code_vehicle'))
            ->with('get_vehicle_meter')
            ->get();            

        setter('additional', $wallet);            

        // Layer 3: akan mengganti data additional jika terdapat replacer
        return [
            'layer1' => $library_max,
            'layer2' => $disable_library, 
            'layer3' => $enable_library, 
        ];
    }

    protected function WithdrawAvailability($code_user){
        
        #$code_user = 'bf271059-f6d6-3bec-a322-d490bf319fe8';

        $library = LibraryWithdraw::class; 
        
        $mutation = GetWithdraw::class;

        $wallet = GetWallet::
            where('code_user', '=', $code_user)
            ->first();

        // check berapa user ini dapat mengakses withdraw
        // sesuai dengan nominal coin n cash yang dimiliki
        $query_library = $library::
            where('status', 'enable')
            ->groupBy(['id'])
            ->havingRaw('SUM(cash + ((cash*fee)/100)) <= '.$wallet->cash_in.'')
            ->havingRaw('SUM(coin + ((coin*fee)/100)) <= '.$wallet->coin_in.'');

        // dibatasi 1 hari sekali withdraw   
        // mengecek withdraw sudah pernah dilakukan belum hari ini
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->where('limit', '=', date('Y-m-d'))
            // ->where('created_at', '>', date('Y-m-d 00:00:00'))
            // ->where('created_at', '<', date('Y-m-d 23:59:59'))
            ->pluck('code_withdraw');   

        $info = 'open';
        if(count($query_mutation)){
            $info = 'close';         
        }

        $enable_library = $query_library
            ->paginate(50);

        $disable_library = $library::
            whereNotIn('code_withdraw', $query_library->pluck('code_withdraw'))
            ->paginate(50);

        if($info == 'open'){
            $info_text = "Kamu hanya bisa melakukan 'Withdraw' maksimal 1 kali sehari";
        }else{
            $info_text = "Terimakasih hari ini Kamu sudah melakukan 'Withdraw', tunggu maksimal 1x24 jam untuk dicairkan ke PB-Pay";
        }
            
        return [
            'disable'   => $disable_library,
            'enable'    => $enable_library, 
            'info'      => $info,
            'info_text' => $info_text,
        ];            
    } 

    protected function MissionAvailability($code_user){

        #$code_user = '7ad1d8a8-edd1-3f6e-99bd-c693dd206915';

        $premium = !isset($_GET['premium']) || empty($_GET['premium']) == false ? false : true;
        $mode = !isset($_GET['mode']) || !empty($_GET['mode']);

        if(!$mode == 'driver' || !$mode == 'service') {
            return [
                "info" => "error url"
            ];
        }

        setter('premium', $premium);

        $limit = DB::
            table('library_limit')
            ->pluck('range','label');

        $mutation = GetMission::class;
        $library = LibraryMission::class;        
        $toolsvehicle = GetToolsVehicle::class;

        // difficulty digunakan untuk melakukan potongan bedasarkan: hard, medium, easy
        $difficulty = GetWallet::
            select(
                DB::raw(
                    '
                    code_user,
                    cash_in,
                    CASE WHEN cash_in < '.$limit['min'].' THEN "easy" 
                         WHEN cash_in BETWEEN '.$limit['min'].' AND '.$limit['max'].' THEN "medium"
                         WHEN cash_in > '.$limit['min'].' THEN "hard"   
                    END as difficulty
                    '
                )
            )
            ->where('code_user', '=', $code_user)
            ->value('difficulty');

        $code_tools_vehicle = $toolsvehicle::
            pluck('code_tools_vehicle');
        
        $tools_vehicle = $toolsvehicle::
            select(
                DB::raw(
                    '
                    code_user,
                    code_tools_vehicle,
                    package,
                    level,
                    CASE WHEN sum(level) = (1) THEN 1
                         WHEN sum(level) = (1+2) THEN 2
                         WHEN sum(level) = (1+2+3) THEN 3
                         ELSE max(level)
                    END AS level
                    '
                )
            )
            ->where('code_user', $code_user)
            ->groupBy([
                'code_user',
                'package',
            ]);
            //->pluck('level');        

        // check vehicle/tools yang sudah dimiliki
        $query_mutation = $mutation::
            select(
                DB::raw("
                    #channel_helper_mutation_tools_vehicle.*,
                    mutation_record_mission.*,
                    channel_helper_mutation_tools_vehicle.code_user,
                    channel_helper_mutation_tools_vehicle.code_tools_vehicle           

                    #mutation_record_mission.id,
                    #mutation_record_mission.code_user,
                    #mutation_record_mission.code_mission,
                    #mutation_record_mission.code_entity,
                    #mutation_record_mission.code_this,
                    #mutation_record_mission.difficulty,
                    #mutation_record_mission.normal,
                    #mutation_record_mission.premium,
                    #mutation_record_mission.date,
                    #mutation_record_mission.mode,
                    #mutation_record_mission.terrain,
                    #mutation_record_mission.tile,
                    #mutation_record_mission.key_title,
                    #mutation_record_mission.key_package,
                    #mutation_record_mission.key_level,
                    #mutation_record_mission.code_tools_vehicle
                ")      
            )
            ->join(
                'channel_helper_mutation_tools_vehicle', function ($join) {
                    $join
                        ->on('channel_helper_mutation_tools_vehicle.code_user', '=', 'mutation_record_mission.code_user');
                }
            )
            // ->where('mutation_record_mission.difficulty', '=', $difficulty) // only premium
            // //->where('mutation_record_mission.date', '=', date('Y-m-d'))
            // ->where('mutation_record_mission.code_user', '=', $code_user)
            // ->where('channel_helper_mutation_tools_vehicle.code_user', '=', $code_user)
            // ->whereIn('mutation_record_mission.code_tools_vehicle', $code_tools_vehicle)   
            // ->whereIn('channel_helper_mutation_tools_vehicle.code_tools_vehicle', $code_tools_vehicle)
            ->premium($premium)
            ->where('mutation_record_mission.date', '=', Carbon\Carbon::now()->format('Y-m-d'))
            ->whereIn('mutation_record_mission.code_tools_vehicle', $code_tools_vehicle)   
            ->whereIn('channel_helper_mutation_tools_vehicle.code_tools_vehicle', $code_tools_vehicle)
            ->whereIn('mutation_record_mission.key_package', $tools_vehicle->pluck('package'))
            ->whereIn('mutation_record_mission.key_level', $tools_vehicle->pluck('level'))
            ->groupBy([
                'mutation_record_mission.code_mission',
                // 'mutation_record_mission.code_user',
                // 'mutation_record_mission.code_this',
                // 'mutation_record_mission.key_title',
                // 'mutation_record_mission.key_package',
                // 'mutation_record_mission.key_level',
            ])
            ->orderBy('mutation_record_mission.id', 'asc');


        // list ini akan dipilih oleh player 'premium mission'
        // randomly will select only 1
        // list akan berkurang ketika as motorcycle,motorbox,taxi,pickup,artisan,cleaner,washer,service has been transfered to mutation_record_mission by today unique
        $data_library_mission = $library::
            select(DB::raw(
                '
                DISTINCT 
                    code_mission,
                    title,
                    mode,
                    difficulty,
                    premium,
                    normal,
                    package,
                    terrain,
                    tile,
                    cash,
                    coin,
                    score,
                    timer,
                    status
                '
            ))
            ->premium($premium)
            ->where('difficulty', $difficulty)
            ->whereIn('package', $tools_vehicle->pluck('package'))
            ->whereNotIn('code_mission', $query_mutation->pluck('code_mission'))
            ->inRandomOrder();
        
        return $too = [
            'premium'               => $premium,
            'tools_vehicle'         => $tools_vehicle->paginate(),
            'query_mutation'        => $query_mutation->paginate(count($query_mutation->pluck('id'))), 
            'data_library_mission'  => $data_library_mission->orderBy('timer', 'desc')->paginate($premium ? 15 : 50),
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

    protected function PurchaseAvailability()
    {
        # code...
        return GetPurchase::paginate(50);
    }

    protected function HelpAvailability()
    {
        # code...
        return GetHelp::paginate(50);
    }

    public function Availability($code_user)
    {
        //K4%0A3%05%00 = key
        //%0Bv%0F%2BNv%B4%B5%05%00 = Help
        //%0B%0C%F7%CBO%0C%0F3%8A%0A7%CCI%CA%0B%B4%05%00 = Achievement
        //%0B%CC%B5%2CM%89%F0%B5%05%00 = Bonus
        //%0B%0E75H%CE%B5%B0%05%00 = Intro
        //%0B%CA%F3%CA%89%0A%F7%2A%88%8A%F0%B5%05%00 = Freebies
        //%0Bs%B7%2CK%F2%F0%B5%05%00 = Tools
        //%0B%CB%0D%CBO%0C%F7%2B%8E%0A%B4%B5%05%00 = Vehicle
        //%0B3%CA1Ht%0F%AA%8C%8CH%B6%05%00 = Withdraw
        //%0B%09%CF%A9J6%CA%29KJ%B7%B5%05%00 = Mission
        //%0Bq%0F%CB%88r%0F%AB%8C%CC%B5%CCH%CE%0D%B4%05%00 = Leaderboard
        //%0B%F5%F0%2A%8B%CA%CD%29%8E%0A%B4%B5%05%00 = Profile
        //%0B%F5%08%AB%8C4%CA%C8H6%0A%B5%05%00 = Purchase

        $key = [];
        
        for($i = 0; $i < count(getter('request')); $i++)
        {
            $key += [decode_key(getter('request'), $i) => decode_value(getter('request'), $i)];
        }        

        switch ($key['key']) {
            case 'Profile':
                return $this->ProfileAvailability($code_user);
                break;
            case 'Purchase': // yang belum, butuh inAppPurchase
                return $this->PurchaseAvailability($code_user);
                break;                
            case 'Achievement':
                return $this->AchievementAvailability($code_user);
                break;
            case 'Bonus':
                return $this->BonusAvailability($code_user);
                break;
            case 'Intro':
                return $this->IntroAvailability($code_user);
                break;
            case 'Freebies':
                return $this->FreebiesAvailability($code_user);
                break;
            case 'Tools':
                return $this->ToolsAvailability($code_user);
                break;
            case 'Vehicle':
                return $this->VehicleAvailability($code_user);
                break;
            case 'Withdraw':
                return $this->WithdrawAvailability($code_user);
                break;
            case 'Mission':
                return $this->MissionAvailability($code_user);
                break;
            case 'Leaderboard':
                return $this->LeaderboardAvailability($code_user);
                break;
            case 'Help':
                return $this->HelpAvailability();
                break;
        }
    }
}