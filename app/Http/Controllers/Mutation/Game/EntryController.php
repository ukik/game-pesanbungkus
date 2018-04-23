<?php

namespace App\Http\Controllers\Mutation\Game;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function index(Request $request)
    {

    }

    public function store(Request $request)
    {

		// $passport = $request->header('Authorization');		
		// $passport = str_replace('Bearer ', '', $passport);

		// $protocol = $_GET['protocol'];

        // return $claim = $request->header('X-Requested-With');	
        
        //return responses(['data' => $request->code_achievement]);

        return responses([
            'security'  => getter('security'), 
            'data'      => $this->entry($request)
        ]);
    }
}
