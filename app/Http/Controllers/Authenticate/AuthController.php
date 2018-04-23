<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        requests($request, $this->auth());

        return responses([
            'security'      => getter('security'), 
            'validation'    => getter('validation'), 
            'status'        => getter('status')
        ]);
    }
}
