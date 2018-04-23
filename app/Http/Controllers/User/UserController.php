<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\User\User;
use App\Model\User\PostUser;

use Faker;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return response()
        ->json([
            'security' => getter('security'),
            'model' => User::status()->filterPaginateOrder()
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
        requests($request, $this->auth());

        // return responses(['security' => getter('security'), 'status' => getter('status')]);
        return responses(['security' => getter('security'), 'data' =>"stored"]);
    }

    public function show(Request $request, $id = null)
    {
        $data = User::status()->where('id', $id)->first();

        return responses(['security' => getter('security'), 'validation' => getter('validation'),  'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $data = PostUser::status()->where("id", $id)->first();

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $requestData = $request->all();
        
        $data = PostUser::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        PostUser::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
