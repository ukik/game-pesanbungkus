<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetAchievement;
use App\Model\Library\PostAchievement;

use Illuminate\Http\Request;
use Session;

class AchievementController extends Controller
{

    public function index(Request $request)
    {        
        $perPage = 25;

        $data = GetAchievement::library()->orderBy('id', 'desc')->paginate($perPage);
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function create(Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        return responses(['security' => getter('security'), 'data' => 'forbidden']);
    }

    public function store(Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $requestData = $request->all();

        PostAchievement::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]); 
    }

    public function show(Request $request, $id)
    {
        $data = GetAchievement::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);         
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $data = GetAchievement::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);         
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $requestData = $request->all();

        $data = PostAchievement::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);         
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        PostAchievement::destroy($id);

        return responses(['security' => getter('security'), 'data' => 'destroyed']);         
    }
}
