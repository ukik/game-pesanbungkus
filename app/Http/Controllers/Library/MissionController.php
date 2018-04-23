<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetMission;
use App\Model\Library\PostMission;

use Illuminate\Http\Request;
use Session;

use ResetMissionEvent;

class MissionController extends Controller
{
  
    public function index(Request $request)
    {
        $data = GetMission::library()->orderBy('id', 'desc')->paginate($perPage);

        return responses(['security' => getter('security'), 'data' => $data]);
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

        PostMission::create($requestData);

        return responses(['security' => getter('security'), 'data' => "forbidden"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetMission::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $data = GetMission::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $requestData = $request->all();

        $data = PostMission::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        PostMission::destroy($id);

        return responses(['security' => getter('security'), 'data' => 'destroyed']);
    }

    public function reset()
    {
        event(new ResetMissionEvent());
        return responses(['data' => 'onprogress']);
    }
}
