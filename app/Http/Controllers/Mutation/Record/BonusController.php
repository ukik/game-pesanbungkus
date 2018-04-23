<?php

namespace App\Http\Controllers\Mutation\Record;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Mutation\Record\GetBonus;
use App\Model\Mutation\Record\PostBonus;

class BonusController extends Controller
{

    public function index(Request $request)
    {
        return responses([
            'security' => getter('security'),
            'model' => GetBonus::with('get_user_profile')->status()->filterPaginateOrder()
        ]);
    }

    public function create(Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        return responses(['security' => getter('security'), 'data' => "forbidden"]);
    }

    public function store(Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        $requestData = $request->all();

        PostBonus::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetBonus::where("code_bonus", 'fe35d20e-724a-3f58-a359-27f79eee88f8')->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        $data = GetBonus::with('get_user_profile')->status()->where("id", $id)->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        $requestData = $request->all();

        $data = PostBonus::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => "updated"]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        PostBonus::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
