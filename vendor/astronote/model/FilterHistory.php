<?php

use DB;

trait FilterHistory
{

    protected function Table($code_user, $table_name, $order)
    {
        return DB::table($table_name)
            ->where('code_user', $code_user)
            ->orderBy($order, 'desc')->paginate(50);
    }
    
    public function History($code_user)
    {
        // K4%0A3%05%00 = key
        // K%F1%F0%CAH%CA%F3%CB%884%0E%2AH22%AD%02%00 = transactions
        // %8B4%B2%2CIv%AF%C8Iq%0F%B5%05%00 = complete
        // %8B%CAu%2BHr%0F%CB%06%00 = failed // CANCELED FEATURE
        // K%F6%F0%CAI%0A%CF1L%0A%B4%B5%05%00 = premium
        // K%CA%B5%ACL%0Aw%2B%06%00 = normal

        $key = [];
        
        for($i = 0; $i < count(getter('request')); $i++)
        {
            $key += [decode_key(getter('request'), $i ) => decode_value(getter('request'), $i)];
        }        

        setter('key', $key['key']);

        switch ($key['key']) {
            case 'transactions':
                return $this->table($code_user, 'channel_helper_mutation_all_transactions', 'created_at');
                break;
            case 'complete':
                return $this->table($code_user, 'channel_helper_mutation_mission_game_complete', 'date');
                break;
            case 'failed':
                return $this->table($code_user, 'channel_helper_mutation_mission_game_failed', 'date');
                break;
            case 'premium':
                return $this->table($code_user, 'channel_helper_mutation_mission_game_premium', 'date');
                break;
            case 'normal':
                return $this->table($code_user, 'channel_helper_mutation_mission_game_normal', 'created_at');
                break;                
        }
    }

}
