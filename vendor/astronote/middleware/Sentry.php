<?php

use App\User;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Sentry
{

    public function handle($request, \Closure $next)
    {
        if ($request->is("api/auth/auth") && Method() == 1)
        {
            return $next($request);
		} 
		
		$passport = $request->header('Authorization');		
		$passport = str_replace('Bearer ', '', $passport);

		$protocol = $_GET['protocol'];

		$claim = $request->header('X-Requested-With');	

		switch(Method())
		{
			case 1:
				$user = User::where('token', $passport)
					->where('api', $request->api)
					->where('protocol', $request->protocol)
					->first();

				break;
			case 0:
				$user = User::where('claim', $claim)
					->where('protocol', $_GET['protocol'])
					->first(); 

				break;
		}
		//return responses(['status' => [Method(),$user, $passport, $request->protocol, $claim]]);
		if (!$user)
		{
			$security = [
				'token' => null, 'api' => null, 'claim' => null, 'protocol' => null, 'scope' => null,	
			];

			// return responses(['status' => 'locked', 'security' => $security, 'validation' => null]);
			return responses(['status' => 'locked', 'security' => null, 'validation' => null]);
			return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
		}		
		
		setter('passport', $passport);
		setter('user', $user);
		
		$response = $next($request);

		return $response;

	}
	public function terminate($request, $response)
	{
        return "protocol clear";
    }   	
}