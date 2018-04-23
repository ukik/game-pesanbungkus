<?php

use App\User;
use App\Model\User\GetUser;
use App\Model\User\PostWallet;

use App\Model\Mutation\Record\PostTools;
use App\Model\Mutation\Record\PostVehicle;

use App\Model\Library\GetTools;
use App\Model\Library\GetVehicle;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Exception\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\PayloadFactory;

use Hash;
use Validator;

class Sentinel___
{

    protected static $complete;
    protected static $hash;
    protected static $user;

	public static function Instance()
	{
		return new Sentinel();
    }

    public static function Register(Illuminate\Http\Request $request)
    {
        //json_decode($request->getContent(), true);
        //$request->json()->all();

        //return $request->only('name', 'password', 'scope', 'email', 'phone');

        // setter('validation', $request->json()->all());
        // return $request->json()->all()['email'];

        $v = Validator::make($request->only('name', 'password', 'scope', 'email', 'phone'), [
            'name'      => 'required|string|max:255',
            'password'  => 'required|string|min:6',
            'scope'     => 'required|string|in:player,admin',
            'email'     => 'required|string|email|max:255|unique:user',
            //'phone'   => 'required|numeric|digits_between:9,15|unique:user',            
            //'email'   => 'required|string|email|max:50|unique:user,email,NULL,id,scope,'.$request->json()->all()['scope'],
            'phone'     => 'required|numeric|digits_between:9,15|unique:user,phone,NULL,id,email,'.$request->json()->all()['email'].',scope,'.$request->json()->all()['scope']            
        ]);

        if ($v->fails()) 
        {
            //response()->json($v->errors()->all(), 400)
            setter('validation', 'failed');
            return setter('status', $v->errors()->all());
        }

        self::$hash = Hash::make(rand(0, 99999));
        
        self::RegisterUser($request);

        self::RegisterJWT($request);

        self::NewPassport($request);

        setter('security', self::$complete);
        setter('status', 'login');

        return self::$complete;            
    }

    public static function Player(Request $request)
    {
        $v = Validator::make($request->json()->all(), [
            'name'      => 'required|string|max:255',
            'password'  => 'required|string|min:6',
            'scope'     => 'required|string|in:player',
            'email'     => 'required|string|email|max:255|unique:user',
            'phone'     => 'required|numeric|digits_between:9,15|unique:user',            
            // 'email' => 'required|string|email|max:50|unique:user,email,NULL,id,scope,'.$request->json()->all()['scope'],
            'phone'     => 'required|numeric|digits_between:9,15|unique:user,phone,NULL,id,email,'.$request->json()->all()['email'].',scope,'.$request->json()->all()['scope']
            
        ]);

        if ($v->fails()) 
        {
            setter('validation', 'failed');
            return setter('status', $v->errors()->all());
        }

        self::$hash = Hash::make(rand(0, 99999));
        
        self::RegisterUser($request);

        self::RegisterJWT($request);

        self::NewPassport($request);
    }

    # Forget Handler
    public static function Forget(Request $request)
    {
        $client = $request->only('value');
        
        $v = validator($client, [
            'value' => 'required|string|max:255',
        ]);

        if (! $v->fails()) { # reverse condition
            return responses(['status' => 'invalid']);
        }

        self::$hash = Hash::make(rand(0, 99999));

        $user = User::where('email', $client)->orWhere('phone', $client);
        $update = $user->update(['remember_token' => bcrypt(rand(0, 99999)).'.'.Hash::make(rand(0, 99999))]);

        self::ForgetJWT($user->first());

        self::RenewalPassport($user->first());

        return self::$complete; //'success';
    }

    # Reset Handler
    public static function Reset(Request $request)
    {
        self::$hash = Hash::make(rand(0, 99999));

        $user = User::where('email', request()->user()->email);
        $user->update(['remember_token' => null]);

        self::ResetJWT($user->first());

        self::RenewalPassport($user->first());

        return self::$complete;;
    }
    
    # Login Handler
    public static function Login(Request $request)
    {
        $v = validator($request->only('email', 'password'), [
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string|min:6',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors()->all(), 400);
        }

        self::$hash = Hash::make(rand(0, 99999));

        self::LoginJWT($request);

        if(self::$user == null)
        {
            return responses('terminated '.Hash::make(rand(0, 99999)));
        }

        self::NewPassport($request);

        setter('security', self::$complete);
        setter('status', 'login');
        
        return self::$complete;
    }
    
    # Create new User
    protected function RegisterUser(Request $request)
    {
        $faker = Faker\Factory::create();
        
        $client = $request->all();
    
        $uuid = $faker->uuid;

        $forms = [
            'code_user'     => $uuid,
            'name'          => $client['name'],
            'email'         => $client['email'],
            'address'       => $client['address'],
            'phone'         => $client['phone'],
            'password'      => bcrypt($client['password']),
            'plain'         => $client['password'], // clien name is password, but server & database as plain
            'scope'         => $client['scope'],
            'claim'         => self::$hash,
            'protocol'      => Hash::make(rand(0, 99999))
        ];

        User::create($forms);	

		# new wallet
		PostWallet::updateOrCreate(
			[
				'code_user' => $uuid,
			],
			[
				'code_user' 	=> $uuid,
				'code_wallet'	=> $faker->uuid,
				'activity' 		=> 0,
				'cash_in' 		=> 0,
				'cash_out'		=> 0,
				'coin_in' 		=> 0,
				'coin_out' 		=> 0,
				'score_in' 		=> 0,
			]
        );
        
        # new tools
        $tools = GetTools::where('level', 1)->where('package', 'cleaner')->first();
        PostTools::updateOrCreate(
			[
				'code_user' => $uuid,
            ],
            [
                'code_user' => $uuid,
                'code_tools' => $tools->code_tools,
                'code_this' => $faker->uuid,
                'package' => $tools->package,
                'title' => $tools->title,
                'level' => $tools->level,
                'name' => $tools->name,
                'description' => $tools->description,
                'cash' => $tools->cash,
                'coin' => $tools->coin,
                'discount' => $tools->discount,
            ]
        );

        # new vehicle
        $vehicle = GetVehicle::where('level', 1)->where('package', 'motorcycle')->first();
        PostVehicle::updateOrCreate(
			[
				'code_user' => $uuid,
            ],
            [
                'code_user' => $uuid,
                'code_vehicle' => $vehicle->code_vehicle,
                'code_this' => $faker->uuid,                        
                'package' => $vehicle->package,
                'title' => $vehicle->title,
                'level' => $vehicle->level,
                'name' => $vehicle->name,
                'description' => $vehicle->description,
                'cash' => $vehicle->cash,
                'coin' => $vehicle->coin,
                'discount' => $vehicle->discount,
                'health' => $vehicle->health,
                'fuel' => $vehicle->fuel,
            ]
        );
    }

    # Create new JWT
    protected function RegisterJWT(Request $request)
    {
        $credentials = ['claim' => [
            'scope' => $request->scope,
            'key'   => self::$hash            
        ]];

        $api = JWTAuth::attempt($request->only('email', 'password'), $credentials);

		User::updateOrCreate(
            ['email' => $request->email],
            [
                'api' => $api, 
            ]
		);
    }  
    
    # Renewal old JWT
    protected function ForgetJWT($request)
    {
        $credentials = ['claim' => [
            'scope' => $request['scope'],
            'key'   => self::$hash            
        ]];

        $api = JWTAuth::fromUser($request, $credentials);
        
        User::updateOrCreate(
            ['email' => $request['email']],
            [
                'api' => $api, 
                'claim' => self::$hash,
                'protocol'  => Hash::make(rand(0, 99999))                
            ]
		);
    }  

    # Renewal old JWT
    protected function ResetJWT($request)
    {
        $credentials = ['claim' => [
            'scope' => $request['scope'],
            'key'   => self::$hash            
        ]];

        $api = JWTAuth::fromUser($request, $credentials);

        User::updateOrCreate(
            ['email' => $request['email']],
            [
                'api' => $api, 
                'claim' => self::$hash,
                'protocol'  => Hash::make(rand(0, 99999))                
            ]
		);
    }      

    # Renewal old JWT
	public function LoginJWT(Request $request) 
	{ 
        $client = $request->only('email', 'password');

        $data = User::where('email', $client['email'])->where('plain', $client['password'])->first();

        if(! $data)
        {
            return self::$user = $data;
        }

        $credentials = ['claim' => [
            'scope' => $data['scope'],
            'key'   => self::$hash            
        ]];
        
        $api = JWTAuth::fromUser($data, $credentials);

        User::updateOrCreate(
            ['email' => $data['email']],
            [
                'api' => $api, 
                'claim' => self::$hash,
                'protocol'  => Hash::make(rand(0, 99999))                
            ]
		);

        self::$user = $data;
	}	

    # Create Fresh Passport
    protected function NewPassport(Request $request)
    {
        $client = \Laravel\Passport\Client::where('password_client', 1)->first();
        if($request->all() == 'undefined' || $request->all() == null){
            $data = $request->json()->all();
        }else{
            $data = $request->all();
        }   
        $forms = [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => $data['scope'],
        ];

        $request->request->add($forms);
        
		// produce access_token & refresh_token
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $json = \Route::dispatch($proxy);

		$jstring = (string) $json;
		
        function removeEverythingBefore($in, $before) 
        {
			$pos = strpos($in, $before);
			return $pos !== FALSE
				? substr($in, $pos + strlen($before), strlen($in))
				: "";
		}
		
        function AccessToken($string)
        {
			$one = strstr($string, 'access_token'); // gets text before /
			$two = strstr($one, 'refresh_token', true); // gets text after /
			$three = removeEverythingBefore($two, 'access_token":"');
			return $four = str_replace('","', '', $three);
		}		
		
        function RefreshToken($string)
        {
			$one = strstr($string, 'refresh_token'); // gets text before /
			$two = removeEverythingBefore($one, 'refresh_token":"');
			return $three = str_replace('"}', '', $two);
		}
		
		User::updateOrCreate(
			['email' => $data['email']],
			[
				'token' => AccessToken($jstring),
			]
		);

        self::$complete = User::where('email', $data['email'])->first();
    }

    # Renewal Old Passport
    protected function RenewalPassport($request)
    {   
        $token = $request->createToken($request, [$request->scope])->accessToken;		

		User::updateOrCreate(
			['email' =>$request->email],
			[
                'token'     => $token,
			]
		);
        
        self::$complete = GetUser::where('email', $request->email)->first();
    }
}
