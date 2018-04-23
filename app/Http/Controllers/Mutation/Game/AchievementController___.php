<?php

namespace App\Http\Controllers\Mutation\Game;

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

        $except = ['mission_played', 'mission_failed', 'no_star_collected'];

        $data = GetAchievement::orderBy('id', 'desc')->where('category', 'bronze')->whereNotIn('term', $except)->paginate($perPage);
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function create(Request $request)
    {
        return "forbidden";
    }

    public function store(Request $request)
    {
        return "forbidden";
    }

    public function show(Request $request, $id)
    {
        $data = GetAchievement::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);         
    }

    public function edit(Request $request, $id)
    {
        return "forbidden";
    }

    public function update($id, Request $request)
    {
        return "forbidden";
    }

    public function destroy(Request $request, $id)
    {
        return "forbidden";
    }
}
