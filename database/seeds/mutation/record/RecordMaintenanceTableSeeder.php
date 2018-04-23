<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=RecordMaintenanceTableSeeder


# Keep All Mutation Data
use App\Model\Mutation\Record\PostAchievement;
use App\Model\Mutation\Record\PostTools;
use App\Model\Mutation\Record\PostVehicle;

# Keep Some Mutation Data (undetermind yet) - Keep 500 Data
# MINIMIZE DATA AFTER MAINTENANCE
use App\Model\Mutation\Record\PostWithdraw;
use App\Model\Mutation\Record\PostPurchase;

# Destroy Mutation Data
# EMPTY DATA AFTER MAINTENANCE
use App\Model\Mutation\Record\PostBonus;
use App\Model\Mutation\Record\PostFreebies;
use App\Model\Mutation\Record\PostGame;
use App\Model\Mutation\Record\PostMission;

# Data Checkpoint
use App\Model\Channel\ChannelIncomeAchievement;
use App\Model\Channel\ChannelIncomeBonus;
use App\Model\Channel\ChannelIncomeFreebies;
use App\Model\Channel\ChannelIncomeGame;
use App\Model\Channel\ChannelIncomeMission;
use App\Model\Channel\ChannelIncomePurchase;

use App\Model\Channel\ChannelOutcomeTools;
use App\Model\Channel\ChannelOutcomeVehicle;
use App\Model\Channel\ChannelOutcomeWithdraw;

use App\Model\Channel\ChannelSummaryIncome;
use App\Model\Channel\ChannelSummaryOutcome;

use App\Model\Library\GetMaintenance as GetLibraryMaintenance;
use App\Model\Library\PostMaintenance as PostLibraryMaintenance;

use App\Model\Mutation\Record\PostMaintenance;

# USER
use App\Model\User\GetWallet;
use App\Model\User\PostWallet;
use App\Model\User\GetSummary;
use App\Model\User\PostSummary;


use Illuminate\Database\Eloquent\SoftDeletes;

class RecordMaintenanceTableSeeder extends Seeder
{
    use SoftDeletes;

    protected $softDelete = true;

    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mutation_record_maintenance')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');     


        function form_fetch_channel($my_model = null, $my_initial){
            # library & mutation maintenance -> code_maintenance,title,due,day,start,finish,description,condition,initial,value,created_at,updated_at,deleted_at

            $faker = Faker\Factory::create();
            
            # MUTATION MAINTENANCE 
            $library_maintenance = GetLibraryMaintenance::where('control', 'this');
        
            $form = [
                'code_maintenance' => $faker->uuid,
                'title' => $library_maintenance->value('title'),
                'due' => $library_maintenance->value('due'),
                'day' => $library_maintenance->value('day'),
                'start' => $library_maintenance->value('start'),
                'finish' => $library_maintenance->value('finish'),
                'description' => $library_maintenance->value('description'),
                'condition' => $library_maintenance->value('condition'),
                # inital & value from channel
                'initial' => $my_initial,
                'value' => $my_model::value('activity')
            ];            

            PostMaintenance::updateOrCreate(
                ['initial' => $my_initial, 'code_maintenance' => $faker->uuid],
                $form
            ); 
                
        }

        # 'count_player'
        function form_fetch_channel2(){
            # library & mutation maintenance -> code_maintenance,title,due,day,start,finish,description,condition,initial,value,created_at,updated_at,deleted_at

            $faker = Faker\Factory::create();
            
            # MUTATION MAINTENANCE 
            $library_maintenance = GetLibraryMaintenance::where('control', 'this');

            $form = [
                'code_maintenance' => $faker->uuid,
                'title' => $library_maintenance->value('title'),
                'due' => $library_maintenance->value('due'),
                'day' => $library_maintenance->value('day'),
                'start' => $library_maintenance->value('start'),
                'finish' => $library_maintenance->value('finish'),
                'description' => $library_maintenance->value('description'),
                'condition' => $library_maintenance->value('condition'),
                # inital & value from channel
                'initial' => 'count_player',
                'value' => ChannelSummaryIncome::value('activity')+ChannelSummaryOutcome::value('activity')
            ];            

            PostMaintenance::updateOrCreate(
                ['initial' => 'count_player', 'code_maintenance' => $faker->uuid],
                $form
            ); 
        }        


        function CALL_MAINTENANCE($index = 0){

            # 1. TRANSFER DATA FROM CHANNEL_INCOME/CHANNEL_OUTCOME -> TABLE ('mutation_record_maintenance')
            form_fetch_channel(ChannelIncomeAchievement::class, 'count_achievement');
            form_fetch_channel(ChannelIncomeAchievement::class, 'sum_cash_achievement');
            form_fetch_channel(ChannelIncomeAchievement::class, 'sum_coin_achievement');

            form_fetch_channel(ChannelIncomeBonus::class, 'count_bonus');
            form_fetch_channel(ChannelIncomeBonus::class, 'sum_cash_bonus');
            form_fetch_channel(ChannelIncomeBonus::class, 'sum_coin_bonus');
            
            form_fetch_channel(ChannelIncomeFreebies::class, 'count_freebies');
            form_fetch_channel(ChannelIncomeFreebies::class, 'sum_cash_freebies');
            form_fetch_channel(ChannelIncomeFreebies::class, 'sum_coin_freebies');

            form_fetch_channel(ChannelIncomeGame::class, 'count_game');
            form_fetch_channel(ChannelIncomeGame::class, 'sum_cash_game');
            form_fetch_channel(ChannelIncomeGame::class, 'sum_coin_game');

            form_fetch_channel(ChannelIncomeMission::class, 'count_mission');
            form_fetch_channel(ChannelIncomeMission::class, 'sum_cash_mission');
            form_fetch_channel(ChannelIncomeMission::class, 'sum_coin_mission');
            
            form_fetch_channel(ChannelOutcomeWithdraw::class, 'count_withdraw');
            form_fetch_channel(ChannelOutcomeWithdraw::class, 'sum_cash_fee_withdraw');
            form_fetch_channel(ChannelOutcomeWithdraw::class, 'sum_coin_free_withdraw');
            
            form_fetch_channel(ChannelOutcomeTools::class, 'count_tools');
            form_fetch_channel(ChannelOutcomeTools::class, 'sum_cash_discount_tools');
            form_fetch_channel(ChannelOutcomeTools::class, 'sum_coin_discount_tools');
            
            form_fetch_channel(ChannelOutcomeVehicle::class, 'count_vehicle');
            form_fetch_channel(ChannelOutcomeVehicle::class, 'sum_cash_discount_vehicle');
            form_fetch_channel(ChannelOutcomeVehicle::class, 'sum_coin_discount_vehicle');
            
            form_fetch_channel(ChannelIncomePurchase::class, 'count_purchase');
            form_fetch_channel(ChannelIncomePurchase::class, 'sum_cash_discount_purchase');
            form_fetch_channel(ChannelIncomePurchase::class, 'sum_coin_discount_purchase');
            
            form_fetch_channel(ChannelSummaryIncome::class, 'sum_score_in_player');
            form_fetch_channel(ChannelSummaryIncome::class, 'sum_cash_in_player');
            form_fetch_channel(ChannelSummaryIncome::class, 'sum_coin_in_player');
            form_fetch_channel(ChannelSummaryOutcome::class, 'sum_cash_out_player');
            form_fetch_channel(ChannelSummaryOutcome::class, 'sum_coin_out_player');
            
            form_fetch_channel2();
            

            # 2. TRANSFER
            # WALLET TO SUMMARY
            $wallet = GetWallet::select(DB::raw(
                "
                `user_wallet`.`id`,
                `user_wallet`.`code_wallet`,
                `user_wallet`.`code_user` AS code_user,
                SUM(`user_wallet`.`activity`) AS activity,
                SUM(`user_wallet`.`cash_in`) AS cash_in,
                SUM(`user_wallet`.`cash_out`) AS cash_out,
                SUM(`user_wallet`.`coin_in`) AS coin_in,
                SUM(`user_wallet`.`coin_out`) AS coin_out,
                SUM(`user_wallet`.`score_in`) AS score_in
                "
            ))
            ->groupBy('code_user')
            ->get();
            
            for ($i=0; $i < count($wallet); $i++) { 
                # code...
                $wallet_form = 
                [
                    'code_summary' => $wallet[$i]['code_wallet'],
                    'code_user' => $wallet[$i]['code_user'],
                    'activity' => $wallet[$i]['activity'],
                    'cash_in' => $wallet[$i]['cash_in'],
                    'cash_out' => $wallet[$i]['cash_out'],
                    'coin_in' => $wallet[$i]['coin_in'],
                    'coin_out' => $wallet[$i]['coin_out'],
                    'score_in' => $wallet[$i]['score_in'],
                ];

                PostSummary::updateOrCreate(
                    [
                        'code_user' => $wallet[$i]['code_user'],
                        'code_summary' => $wallet[$i]['code_wallet'],                    
                    ],
                    $wallet_form
                );
            }            

            # 3. UPDATE TABLE('library_maintenance')    
            # After CONSOLIDATION, I consider to NOT INCLUDE this process trough Event
            # LIBRARY
            # This Week -> move data to -> Next Week
            # Next Week refresh
            $faker = Faker\Factory::create();        
            $day = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
            $conditions = ['pass','abort','done'];

            PostLibraryMaintenance::updateOrCreate(
                ['control' => 'this'],
                [
                    'code_maintenance' => $faker->uuid,
                    'title' => $faker->realText($maxNbChars = 50, $indexSize = 2),
                    'due' => Carbon\Carbon::now()->parse('next '.$day[array_rand($day)])->addWeeks(0)->subDays(-($index))->toDateString(),
                    'day' => $day[array_rand($day)],
                    'start' => date("h:i", mt_rand(1, time())), 
                    'finish' => date("23:i", mt_rand(1, time())),
                    'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                    'control' => 'this',
                    'condition' => $conditions[mt_rand(0,2)]
                ]
            );	                   
       
        }


        for ($i=0; $i < 10; $i++) { 
            # code...
            CALL_MAINTENANCE($i);
        }


        // DELETE ALL

        DB::table('user_summary', function ($table) {
            $table->softDeletes();
        })->delete();


        // DB::table('user_summary', function ($table) {
        //     $table->softDeletes();
        // })->update('deleted_at', date());


        // for($c = 0; $c < count(GetSummary::all()); $c++){
        //     PostSummary::destroy(GetSummary::value('id'));                        
        // }

        # CLEAR TABLE
        // use App\Model\Mutation\Record\PostBonus;
        // use App\Model\Mutation\Record\PostFreebies;
        // use App\Model\Mutation\Record\PostGame;
        // use App\Model\Mutation\Record\PostMission;

        // PostBonus::destroy($id)        
        // PostFreebies

    }
}
