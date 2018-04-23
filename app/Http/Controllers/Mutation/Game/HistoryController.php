<?php

namespace App\Http\Controllers\Mutation\Game;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function show(Request $request, $code_user)
    {
        // if (clean($request) == 'false'){
        //     return responses(['security' => null, 'data' => "false"]);   
        // };

        return responses([
            'security'  => getter('security'), 
            'data'      => $this->history($code_user), 
            'key'       => getter('key')
        ]);
    }

}
