<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\User\UserRecordEarning;
use App\Model\User\PostUserRecordEarning;

use Illuminate\Http\Request;
use Session;

class UserRecordEarningController extends Controller
{

    public function index(Request $request)
    {
        if (clean() == 'false'){
            return 'false';   
        };
                
        return response()
        ->json([
            'security' => getter('security'),
            'model' => UserRecordEarning::with('get_user_profile')->filterPaginateOrder()
        ]);
    }

    public function create()
    {
        if (clean() == 'false'){
            return 'false';   
        };

        return responses(['security' => getter('security'), 'data' => "forbidden"]);                    
    }

    public function store(Request $request)
    {
        if (clean() == 'false'){
            return 'false';   
        };
                
        $requestData = $request->all();

        PostUserRecordEarning::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);                    
    }

    public function show($id)
    {
        if (clean() == 'false'){
            return 'false';   
        };
                
        $data = UserRecordEarning::findOrFail($id)->with('get_user_profile')->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);                    
    }

    public function edit($id)
    {
        if (clean() == 'false'){
            return 'false';   
        };
                
        $data = UserRecordEarning::with('get_user_profile')->where("id", $id)->first();   

        return responses(['security' => getter('security'), 'data' => $data]);                    
    }

    public function update($id, Request $request)
    {
        if (clean() == 'false'){
            return 'false';   
        };
                
        $requestData = $request->all();

        $user_profile = PostUserRecordEarning::findOrFail($id);

        $user_profile->update($requestData);

        return responses(['security' => getter('security'), 'data' => "updated"]);                    
    }

    public function destroy($id)
    {
        if (clean() == 'false'){
            return 'false';   
        };
                
        PostUserRecordEarning::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);                    
    }
}
