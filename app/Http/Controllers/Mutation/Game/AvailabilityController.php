<?php

namespace App\Http\Controllers\Mutation\Game;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request, $code_user)
    {
        return responses([
            'security' => getter('security'), 
            'data' => $this->availability($code_user), 
            'additional' => getter('additional')
        ]);
    }
}
