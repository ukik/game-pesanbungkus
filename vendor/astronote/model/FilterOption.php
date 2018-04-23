<?php

use Request;

trait FilterOption
{

    public function scopeStatus($query)
    {
        $request = [];
        
        for($i = 0; $i < count(getter('request')); $i++)
        {
            $request += [decode_key(getter('request'), $i ) => base_paginate_value(getter('request'), $i)];
        }
        
        if(isset($request['status'])){
            if($request['status'] == "recovery"){
                return $query->onlyTrashed();
            }else{
                return $query->where('status', '=', $request['status']);
            }
        }else{
            return;
        }
        
    }       

    public function scopeMisc($query)
    {
        $request = [];
        
        for($i = 0; $i < count(getter('request')); $i++)
        {
            $request += [decode_key(getter('request'), $i ) => base_paginate_value(getter('request'), $i)];
        }

        switch(Request::segment(4)){
            case "mission":
                if(!empty($request['misc'])){
                    return $query->where('mode', $request['misc']);
                }else{
                    return;
                }
                break;
            case "purchase":
                if(!empty($request['misc'])){
                    return $query->where('currency', '=', $request['misc']);
                }else{
                    return;
                }
                break;
            }
    }  
}
  