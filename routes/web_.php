<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::resource('/testing', 'Library\AchievementController');

// Route::get('/', function () {

//     $code_user = DB::table('library_achievement')->get();

//     for ($i=0; $i < count($code_user); $i++) {
//       # code...
//       echo $code_user[$i]->title;
//     }

//     foreach ($code_user as $key => $code_user) {
//       # code...
//       //echo $code_user->title;
//     }

//     return 'done';

//     function getDataUser ($n) {
//       $code_user = DB::table('user')->pluck('code_user');
//       for ($i=0; $i < count($code_user) ; $i++) {
//         # code...
//         return $code_user[$n];
//       }
//     }

//     return getDataUser (5);
//     //return ($code_user);
//     //$code_tools = DB::table('library_tools')->pluck('code_tools');

//     //return array_values(array($code_tools[2]))[0];
// });


// Route::get('/achievements', function(){
//     return date("Y-m-d H:i:s");
//     return App\DefaultAchievement::where('code_term', 'a7ff4a3b-4326-3a91-88ce-90e437524802')->get();
//     return DB::table('library_achievement')->select('title','description')->get();
// });

// // Route::resource('admin/posts', 'Admin\PostsController');



use DB;
use App\User;
use FilterJWT;

use ForgetEvent;

# Data Checkpoint
use RegisterEvent;
use FilterCurl as Curl;
use App\Events\Maintenance;
use App\Model\User\GetWallet;
use App\Model\User\GetSummary;

use App\Model\User\PostWallet;

use App\Model\User\PostSummary;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Model\User\GetWalletIncome;

use Illuminate\Support\Facades\URL;
use App\Model\User\PostWalletIncome;

use App\Model\Mutation\Record\GetGame;

use App\Model\Mutation\Record\GetBonus;

# USER
use App\Model\Mutation\Record\GetTools;
use App\Model\Channel\ChannelIncomeGame;
use App\Model\Channel\ChannelIncomeBonus;
use App\Model\Mutation\Record\GetMission;

use App\Model\Mutation\Record\GetVehicle;

use Tymon\JWTAuth\Exception\JWTException;

use App\Model\Channel\ChannelOutcomeTools;

use App\Model\Mutation\Record\GetFreebies;
use App\Model\Mutation\Record\GetPurchase;

use App\Model\Mutation\Record\GetWithdraw;

use App\Model\Channel\ChannelIncomeMission;
use App\Model\Channel\ChannelSummaryIncome;

use App\Model\Channel\ChannelIncomeFreebies;
use App\Model\Channel\ChannelIncomePurchase;
use App\Model\Channel\ChannelOutcomeVehicle;
use App\Model\Channel\ChannelSummaryOutcome;
use App\Model\Channel\ChannelOutcomeWithdraw;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Mutation\Record\PostMaintenance;
use App\Model\Channel\ChannelIncomeAchievement;
use App\Model\Library\GetMaintenance as LibraryMaintenance;


Route::get('/wee', function () {
	return file_get_contents(public_path('1.js'));
	$files = File::allFiles(public_path('./weex/1.js'));
	foreach ($files as $file)
	{
		echo (string)$file, "\n";
	}
	return;
});

// let Login = db.ref('game-auth-login');
// let Register = db.ref('game-auth-register');
// let Forget = db.ref('game-auth-forget');

Route::get('/artisan', function(){
	// Artisan::call('queue:listen', [
	// 	'--queue' => 'auth,activity,email',
	// 	'--tries' => 1,
	// 	'--timeout' => 120
	// ]);
	// return Artisan::call('queue:listen --queue=activity --tries=1');
	// echo exec('queue:listen --queue=auth,activity,email --tries=1 --timeout=120');
	//Artisan::queue('queue:listener --queue=auth,activity,email');
	// Artisan::queue('queue:listen', [
	// 	'--queue' => 'auth,activity,email',
	// 	'--tries' => 1,
	// 	'--timeout' => 120
	// ], 'auth' );	
});

Route::get('/listener/{tipe?}', function($tipe){
	$email = 'muhamadduki@gmail.com';
	for ($i=0; $i < 10 ; $i++) { 
		# code...
		switch (Request::segment(2)) {
			case 'bonus':
				$bonus = GetBonus::where('id', 50)->first();
				event(new BonusEvent($email, $bonus));
				break;
			case 'freebies':
				$freebies = GetFreebies::where('id', 50)->first();
				event(new FreebiesEvent($email, $freebies));
				break;
			case 'mission':
				$mission = GetMission::where('id', 50)->first();
				event(new MissionEvent($email, $mission));
				break;
			case 'game':
				$game = GetGame::where('id', 51)->first();
				event(new GameEvent($email, $game));
				break;
			case 'tools':
				$tools = GetTools::where('id', 50)->first();
				event(new ToolsEvent($email, $tools));
				break;			
			case 'vehicle':
				$vehicle = GetVehicle::where('id', 50)->first();
				event(new VehicleEvent($email, $vehicle));				
				break;
			case 'purchase':
				$purchase = GetPurchase::where('id', 50)->first();
				event(new PurchaseEvent($email, $purchase));
				break;
			case 'withdraw':
				$withdraw = GetWithdraw::where('id', 50)->first();
				event(new WithdrawEvent($email, $withdraw));
				break;
			case 'forget':
				event(new ForgetEvent($email));
				break;
			case 'login':
				event(new LoginEvent($email));
				break;
			case 'register':
				event(new RegisterEvent($email));
				break;
			case 'reset':
				event(new ResetEvent($email));
				break;
		}
	}
});


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// ---------------------------------------------------------------------------------------------
// JWT READY
// ---------------------------------------------------------------------------------------------

Route::post('jwt/register', 'JWT@RegisterJWT');

Route::post('jwt/generate', 'JWT@GenerateJWT');

Route::post('jwt/parse', 'JWT@ParseJWT');

Route::post('jwt/object', 'JWT@ObjectJWT');

Route::post('jwt/custom', 'JWT@CustomJWT');

Route::post('jwt/get', 'JWT@GetJWT');

Route::post('jwt/payload', 'JWT@PayloadJWT');

Route::post('jwt/middleware', 'JWT@MiddlewareJWT')->middleware(['claim','jwt.auth']);

Route::post('jwt/refresh', 'JWT@RefreshJWT');

// ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------
// PASSPORT READY
// ---------------------------------------------------------------------------------------------

Route::post('/auth/token', 'Passport@RequestTokens');

Route::post('/auth/scopes', 'Passport@CheckScopes')->middleware('auth:api');

Route::post('/auth/personal', 'Passport@PersonalAccessTokens')->middleware('auth:api');

Route::post('/auth/user', 'Passport@PersonalAccessUser')->middleware('auth:api');

Route::post('/auth/token/track', 'Passport@TokenScopeTrack')
	->middleware(['scope:check-status,place-orders','auth:api']);
	// middleware scope tidak boleh lebih banyak dari scope yang dimiliki token
	// jika token hanya memiliki 1 scope, maka middleware hanya boleh 1 scope dengn format scopes:....
	// jika token hanya memiliki 1 scope, maka middleware boleh banyak scope tapi dengan format scope:...,...,...
	// scope:...,...,... sama dengan OR
	// scopes:...,...,... sama dengan AND
	//->middleware(['scope:check-status','auth:api']); # equal token has BEWTEEN to check-status OR place-orders
	//->middleware(['scopes:check-status,place-orders','auth:api']); # equal token must has BOTH to check-status AND place-orders

Route::post('/auth/token/header', 'Passport@TokenHeader')->middleware('auth:api');

Route::post('/auth/token/only', 'Passport@RequestTokensOnly');

Route::post('/auth/refresh', 'Passport@RefreshToken')->middleware('auth:api');

Route::post('/auth/credentials', 'Passport@ClientCredentials')->middleware('auth:api');
Route::post('/auth/credentials/user', 'Passport@ClientCredentials')->middleware(['client']);

// ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------


Route::get('mencoba', function () {
	return $data_tools_vehicle = DB::table('channel_helper_mutation_tools_vehicle')
	->select(
		DB::raw(
			'
			*,
			CASE WHEN sum(level) = (1) THEN 1
				WHEN sum(level) = (1+2) THEN 2
				WHEN sum(level) = (1+2+3) THEN 3
				ELSE max(level)
			END AS `level`
			'
		)
	)
	->where('code_user', '238718b7-e5e8-3553-9ae1-8bdf504662e5')
	->groupBy(['code_user','package', 'level'])
	->get()->count();
});


Route::get('transaction/mission', function () {

	$parameter = [];
	
	foreach ($_REQUEST as $key => $value) {
		$parameter += [$key => $value];
	}        	

	$items = [
		[
			"lotteryId" => 3,
			"drawId" => 303,
			"estimatedJackpotLC" => 60000000.0,
			"endsOn" => "2014-12-10T22:00:00Z"
		],
		[
			"lotteryId" => 2,
			"drawId" => 326,
			"estimatedJackpotLC" => 10000000.0,
			"endsOn" => "2014-12-12T13:00:00Z"
		],
		[
			"lotteryId" => 1,
			"drawId" => 331,
			"estimatedJackpotLC" => 31000000.0,
			"endsOn" => "2014-12-12T14:00:00Z"
		]
	];


	return response()->json(compact('items'));
	//dd(User::where('id',1000)->value('id');

	// return $tools_vehicle = DB::table('channel_helper_mutation_tools_vehicle')
	// 	->select(
	// 		DB::raw(
	// 			'
	// 			*,
	// 			CASE WHEN sum(level) = (1) THEN 1
	// 				WHEN sum(level) = (1+2) THEN 2
	// 				WHEN sum(level) = (1+2+3) THEN 3
	// 				ELSE max(level)
	// 			END AS `level`
	// 			'
	// 		)
	// 	)
	// 	->where('code_user','238718b7-e5e8-3553-9ae1-8bdf504662e5')
	// 	->groupBy(['code_user','package'])
	// 	->get();
		//->get(['code_user','code_tools_vehicle','code_this']);
	return App\Model\Library\GetVehicle::where('level', 1)->where('package', 'motorcycle')->first()->cash;
	
	$data = FilterTransaction::ToolsAvailability();
	return ($data);
});


Route::get('seeder', function(){
	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	DB::table('mutation_record_purchase')->truncate();
	DB::statement('SET FOREIGN_KEY_CHECKS=1;');

	$faker = Faker\Factory::create();

	function randomDay()
	{
		$startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
		$endDate = new Carbon\Carbon("today");
		return $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
	}

	$code_user = DB::table('user')->pluck('code_user');

	$data_purchase = DB::table('library_purchase')->get();

	for ($h = 0; $h < count($code_user); $h++) {
		# code...
		$user = array_values(array($code_user[$h]))[0];

		for ($i = 0; $i < count($data_purchase); $i++) {

			$startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
			$endDate = new Carbon\Carbon("today");
			$randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
										
			DB::table('mutation_record_purchase')->insert(
				[
					'code_user' => $user,
					'code_purchase' => $data_purchase[$i]->code_purchase,
					'title' => $data_purchase[$i]->title,
					'currency' => $data_purchase[$i]->currency,
					'label' => $data_purchase[$i]->label,
					'price' => $data_purchase[$i]->price,
					'value' => $data_purchase[$i]->value,
					'discount' => $data_purchase[$i]->discount,
					'created_at' => $randomDate,
				]
			);

			# UPDATE WALLET
			PostWallet::updateOrCreate(
				[
					# as index
					'code_user' => $user,
				],
				[
					# as value
					'code_wallet' => $faker->uuid,
					'code_user' => $user,
				]
			);

			$source = DB::table('user_wallet')->where('code_user', $user);
			// PERLU HELPER untuk merubah currency: row -> column
			// TO BE CONTINUED....
			
			$payload = [
				'code_user' => $user,
				'code_wallet' => $faker->uuid,
				'code_user' => $user,
				'activity' => $source->value('activity') + 1,
				'cash_in' => $source->value('cash_in'),
				'cash_out' => 0,
				'coin_in' => $source->value('coin_in'),
				'coin_out' => 0,
				'score_in' => $source->value('score_in'),
			];

			PostWallet::updateOrCreate(
				# can more than one using
				# ['code_user' => $user, 'id' => 1],
				['code_user' => $user],
				$payload
			);
		}
	}
	return 123;
});


Route::post('/event', function(Request $request)
{
	event(new RegisterEvent("xxxxxxxxxxxxxxxxxxxx"));
})->middleware('auth');

Route::get('/', function(){
	return view('emails.register');	
});

Route::get('/function', function(){
	$param1 = [
		'data1' => [
			'no1' => '00000',
			'no2' => '22222'
		]
	];
	$param2 = [
		'data2' => [
			'no1' => '11111',
			'no2' => '22222'
		]
	];
	function param(array $b = null){
		return $b['data1'];
	}

	return param($param1);

});

Route::get('/fire', function(){
	$user = User::find(100);
	$user1 = User::all()[49];
	#return email();

	return event(new RegisterEvent());	

	// $firebase = new Firebase(); 

	// //sending push notification and displaying result 
	// echo $firebase->send('123456789', "123456789");
	// return;

	$fire = 'cloud-email-register.json';

	$data = [
		'author' => 'author1',
		'title' => 'title1',
		'urlxxxxxxxx' => 'url1'					
	];
	
	//return ($user);

	// usage
	$curl = new Sender('https://vue-http-d71e9.firebaseio.com/'.$fire, $user1);
	echo $curl;
	// try {
	// 	echo $curl;
	// } catch (\RuntimeException $ex) {
	// 	die(sprintf('Http error %s with code %d', $ex->getMessage(), $ex->getCode()));
	// }

	return;
});


Route::get('/email', function(Request $request)
{


	$sender = 'pt.pensabungkus@gmail.com';
	$subject = "Game-Pesanbungkus Forget Account";

	$user = User::where('token', Getter('passport'))->first();

	Mail::send('emails.forget', ['user' => $user], function($message)
	{
		$message->to('muhamadduki@gmail.com', 'John Smith')->subject('Welcome!');
	});
	return;
	

	$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
	
	$beautymail->send('emails.forget', ['user' => $user], function($message)
	{
		$message
			->from($sender)
			->to('muhamadduki@gmail.com', 'UKIK')
			->subject($subject);
	});  
	
	return;

	event(new ForgetEvent(
		$sender = 'pt.pensabungkus@gmail.com', 
		$subject = "Game-Pesanbungkus Registration Account"));


	return;
	// return $request->user()->tokenCan('check-status') ? 'Correct ' : 'Incorrect ';
});

#JWT
Route::post('/jwt', function(){

	return view('vendor.mail.html.table');

	// $token = $request->header('Proxy-Authorization');		
	// $token = str_replace('Bearer ', '', $token);

	// $proxy = (substr($token, 0, 100));

	// // $api = User::where('email', $request->)->value('api');

	// if (strpos($api, $proxy) !== false) {
	// 	return 'true';
	// }
	return getter('passport');
	
	$ca = (Cache::pull(Getter('passport')));
	//Cache::forget(Getter('passport'));	
	return $ca;

	return Cache::pull('sentry');
	// grab some user
	return request()->user();

	$token = JWTAuth::fromUser($user);

	$customClaims = ['foo' => 'bar', 'baz' => 'bob'];
	
	$payload = JWTFactory::make($customClaims);
	
	$token = JWTAuth::encode($payload);

	return JWTAuth::parseToken()->authenticate();

	// return $token = JWTAuth::attempt(['password' => 'xxxxxx']);

	// $token = new FilterJWT();
	// $credentials = ['user' => 'xxx']; //$request->only('email', 'password');
	// return $token->getAuthenticateToken($credentials);

	return 'index';
});


Route::post('/jwt/post', function(){
	
});
Route::get('/jwt/show/{id?}', function($id){
	return $id.' show';
});
	






Route::post('/curl', function(){
	return "xxxxxxxxxxxxx";
	//return $request->all();
})->name('curl');


Route::get('/test3', function(){

	return "FORBIDDEN SAME DOMAIN";

	$xml = simplexml_load_string(
		file_get_contents(route('curl')),
		'SimpleXMLElement',
		LIBXML_NOCDATA
	);
	
	print_r($xml);
	return '';


	$post = [
		'username' => 'user1',
		'password' => 'passuser1',
		'gender'   => 1,
	];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/curl');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

	session_write_close();

	$response = curl_exec($ch);
	
	var_export($response);	
	return;

	$url = route('curl');
		// set post fields
		$post = [
			'username' => 'user1',
			'password' => 'passuser1',
			'gender'   => 1,
		];

		$ch = curl_init('http://www.example.com');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		// do anything you want with your response
		var_dump($response);
	return;


	$curl = new Curl($url, array(
	    CURLOPT_POSTFIELDS => array('username' => 'user1')
	));

	try {
		echo $curl;
	} catch (\RuntimeException $ex) {
		die(sprintf('Http error %s with code %d', $ex->getMessage(), $ex->getCode()));
	}

});

Route::get('/test2', function(){

	event(new Maintenance('super@gmail.com'));
	return;	

	return $users = DB::select('select * from mutation_record_withdraw where id = ?', array(1));
	
	$users = DB::select( DB::raw("select * from users where username = :username"), array('username' => Input::get("username")));


});

Route::get('/test1', function(){
	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	DB::table('library_tools')->truncate();
	DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
	  
	$faker = Faker\Factory::create();
	$label = ['artisan','cleaner','washer','service'];
	$name = ['Pertukangan','Kebersihan','Pencucian','Pelayanan'];
	$level = [1,2,3];

	for ($i=0; $i < count($level); $i++) {
		# code...
		DB::table('library_tools')->insert(
			[
			  'code_tools' => $faker->uuid,
			  'package' => $label[0],
			  'level' => $level[$i],
			  'name' => $name[0],
			  'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
			  'cash' => array_values([25000,50000,75000])[$i],
			  'coin' => array_values([25000,50000,75000])[$i],
			  'discount' => mt_rand(5,15),
			  'status' => 'enable',
			]
	  );
	}
	
	return;

	// return DB::table('user_summary', function ($table) {
	// 	//return $table->softDeletes();
	// })->delete();

	//DB::table('user_summary')->delete();

	//return GetSummary::withTrashed()->get();

	// SOFTDELETE ALTERNATIVE
	return DB::table('user_summary')->update(['deleted_at' => date('Y-m-d H:i:s')]);
	

	$wallet = GetWallet::select(DB::raw(
		"
		`user_wallet`.`id`,
		`user_wallet`.`code_wallet`,
		`user_wallet`.`code_user` AS code_user,
		SUM(`user_wallet`.`activity`) AS activity,
		SUM(`user_wallet`.`cash_in`) AS cash_in,
		SUM(`user_wallet`.`cash_out`) AS cash_out,
		SUM(`user_wallet`.`coin_in`) AS coin_in,
		SUM(`user_wallet`.`coin_out`) AS coin_out,
		SUM(`user_wallet`.`score_in`) AS score_in
		"
	))
	->groupBy('code_user')
	->get();
	
	for ($i=0; $i < count($wallet); $i++) { 
		# code...
		$wallet_form = 
		[
			'code_summary' => $wallet[$i]['code_wallet'],
			'code_user' => $wallet[$i]['code_user'],
			'activity' => $wallet[$i]['activity'],
			'cash_in' => $wallet[$i]['cash_in'],
			'cash_out' => $wallet[$i]['cash_out'],
			'coin_in' => $wallet[$i]['coin_in'],
			'coin_out' => $wallet[$i]['coin_out'],
			'score_in' => $wallet[$i]['score_in'],
		];

		PostSummary::updateOrCreate(
			[
				'code_user' => $wallet[$i]['code_user'],
				'code_summary' => $wallet[$i]['code_wallet'],                    
			],
			$wallet_form
		);
	}
});

Route::get('/test', function(){





    function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mutation_record_bonus')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker\Factory::create();

        $code_user = DB::table('user')->select('code_user')->get();
        $code_bonus = DB::table('library_bonus')->get();

        foreach ($code_user as $key => $code_user) {
            # code...
            $user = $code_user->code_user;

            for ($i = 0; $i < count($code_bonus); $i++) {
                # code...

                $startDate = new Carbon\Carbon('first day of October'); //date("Y-m-d 00:00:00");
                $endDate = new Carbon\Carbon("today");
                $randomDate = Carbon\Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))->format('Y-m-d h:i:s');
                
                DB::table('mutation_record_bonus')->insert(
                    [
                        'code_user' => $user,
                        'code_bonus' => $code_bonus[$i]->code_bonus,
                        'title' => $code_bonus[$i]->title,
                        'description' => $code_bonus[$i]->description,
                        'cash' => $code_bonus[$i]->cash,
                        'coin' => $code_bonus[$i]->coin,
                        'claim' => $code_bonus[$i]->claim,
                        'score' => $code_bonus[$i]->score,
                        'created_at' => $randomDate,
                    ]
                );

                # UPDATE WALLET
                PostWallet::updateOrCreate(
                    [
                        # as index
                        'code_user' => $user,
                    ],
                    [
                        # as value
                        'code_wallet' => $faker->uuid,
                        'code_user' => $user,
                    ]
                );

                $source = DB::table('user_wallet')->where('code_user', $user);
                $source2 = DB::table('mutation_record_bonus')->where('code_user', $user);

                $cash = ($user == $source->value('code_user') ? $source2->value('cash') : 0);
                $coin = ($user == $source->value('code_user') ? $source2->value('coin') : 0);
                $score = ($user == $source->value('code_user') ? $source2->value('score') : 0);
                
                $payload = [
                    'code_user' => $user,
                    'code_wallet' => $faker->uuid,
                    'code_user' => $user,
                    'activity' => $source->value('activity') + 1,
                    'cash_in' => $source->value('cash_in') + $cash,
                    'cash_out' => 0,
                    'coin_in' => $source->value('coin_in') + $cash,
                    'coin_out' => 0,
                    'score_in' => $source->value('score_in') + $cash,
                ];

                PostWallet::updateOrCreate(
                    # can more than one using
                    # ['code_user' => $user, 'id' => 1],
                    ['code_user' => $user],
                    $payload
                );
            }
        }
	}
	
	return run();













	
	return \DB::table('mutation_record_achievement')->value('code_user');

	return \DB::table('channel_helper_record_maintenance')->paginate();

	event(new Maintenance('super@gmail.com'));

	return response()->json('done');
	
	
	$now = [
		Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays(0)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays(1)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays(2)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays(3)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays(4)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays(5)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays(6)->subDays(1)->toDateString(),	
		'',
		Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays(0)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays(1)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays(2)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays(3)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays(4)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays(5)->subDays(1)->toDateString(),
		Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays(6)->subDays(1)->toDateString(),	
	];
	
	return $now;

	return calculation_now();
	return Carbon\Carbon::now()->parse('this wednesday')->toDateString();
	
});






Route::get("/from_api", function(){

	return Session::get("obfuscator");

	return Carbon\Carbon::now()->parse('last wednesday')->subWeeks(0)->toDateString();
	return Carbon\Carbon::now()->format('l, d F, Y');

	return $code_entity = DB::table('library_entity')
	->groupBy('code_entity')
	->get();


	return $code_entity = DB::table('library_entity')->select(DB::raw(
	'DISTINCT code_entity as code_entity'
	))
	->pluck('code_entity');
	//->get();

	return $code_entity[0]->code_entity;


	$a = App\Model\Mutation\Record\GetTools::all();
	return App\Model\Mutation\Record\GetTools::all()->union($a);

	

	$tools = DB::table('channel_outcome_record_tools')
	->select(DB::raw('
		code_user, 
		SUM(channel_outcome_record_tools.cash_out) as cash_out,
		SUM(channel_outcome_record_tools.coin_out) as coin_out
	'));
	// ->whereNull('cash_out');

	$vehicle = DB::table('channel_outcome_record_vehicle')
	// ->whereNull('cash_out')
	->select(DB::raw('
		code_user, 
		SUM(channel_outcome_record_vehicle.cash_out) as cash_out,
		SUM(channel_outcome_record_vehicle.coin_out) as coin_out
	'))
	->union($tools)
	->groupBy('code_user')
	->get();

	return $vehicle;
});
	
	
	// Route::middleware('auth:api')->get('/user', function (Request $request) {
	//     return $request->user();
	// });
	
	// header('Access-Control-Allow-Origin: *');
	// header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
	// header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, X-Auth-Token");
	
	// Route::get('/carbon', function (){
	//     #  WIT: Asia/Jayapura
	//     #  WITA: Asia/Makassar
	//     #  WIB: Asia/Jakarta
	//     #  WIB: Asia/Pontianak
	
	//     // parse a specific string - 2016-01-01 00:00:00
	//     // $newYear = new Carbon\Carbon('first day of January 2016');
	//     // set a specific timezone - 2016-01-01 00:00:00
	//     // $newYearPST = new Carbon\Carbon('first day of January 2016', 'America\Pacific');
	
	//     # TODAY - Start Day
	//     $startDay = date("Y-m-d 00:00:00");
	//     $startDay = new Carbon\Carbon("today");
	//     $startDay = Carbon\Carbon::today();
	//     $startDay = Carbon\Carbon::yesterday()->addDays(1);
	
	//     # TODAY - Current Day
	//     $currentDay = date("Y-m-d H:i:s");
	//     $currentDay = Carbon\Carbon::now(new DateTimeZone('Asia/Makassar'));
		
	//     # TODAY - End Day
	//     $endDay = Carbon\Carbon::tomorrow()->subMinutes(1);
	//     $endDay = date("Y-m-d 23:59:00");
	
	//     # TOMORROW - Start Tomorrow
	//     $startTomorrow = Carbon\Carbon::tomorrow();
	//     # TOMORROW - Current Tomorrow
	//     $currentTomorrow = Carbon\Carbon::tomorrow(new DateTimeZone('Asia/Makassar'));
	//     # TOMORROW - End Tomorrow
	//     $endTomorrow = Carbon\Carbon::today()->addDays(2)->subMinutes(1);
	//     return $endTomorrow = Carbon\Carbon::tomorrow()->format("Y-m-d 23:59:00");
		
	//     # WEEK - Previous Week
	//     # start day is monday
	//     $startOfWeek = Carbon\Carbon::now()->startOfWeek()->subWeeks(1)->format('Y-m-d h:i:s');
	//     # end day is sunday
	//     $endOfWeek = Carbon\Carbon::now()->endOfWeek()->subWeeks(1)->format('Y-m-d h:i:s');
	//     // return "Previous Week: startOfWeek ".$startOfWeek." --- endOfWeek ".$endOfWeek."";
	
	//     # WEEK - Current Week
	//     # start day is monday
	//     $startOfWeek = Carbon\Carbon::now()->startOfWeek()->format('Y-m-d h:i:s');
	//     # end day is sunday
	//     $endOfWeek = Carbon\Carbon::now()->endOfWeek()->format('Y-m-d h:i:s');
	//     // return "Current Week: startOfWeek ".$startOfWeek." --- endOfWeek ".$endOfWeek."";
	
	//     # WEEK - Next Week
	//     # start day is monday
	//     $startOfWeek = Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->format('Y-m-d h:i:s');
	//     # end day is sunday
	//     $endOfWeek = Carbon\Carbon::now()->endOfWeek()->addWeeks(1)->format('Y-m-d h:i:s');
	//     // return "Next Week: startOfWeek ".$startOfWeek." --- endOfWeek ".$endOfWeek."";
	
	//     # MONTH - Previous Month
	//     $firstDay = new Carbon\Carbon('first day of last month'); 
	//     $lastDay = new Carbon\Carbon('last day of last month'); 
	//     // return "Previous Month: firstDay ".$firstDay." --- lastDay ".$lastDay."";
		
	//     # MONTH - Current Month
	//     $firstDay = new Carbon\Carbon('first day of this month'); 
	//     $lastDay = new Carbon\Carbon('last day of this month'); 
	//     // return "Current Month: firstDay ".$firstDay." --- lastDay ".$lastDay."";
	
	//     # MONTH - Next Month
	//     $firstDay = new Carbon\Carbon('first day of next month'); 
	//     $lastDay = new Carbon\Carbon('last day of next month');
	//     // return "Next Month: firstDay ".$firstDay." --- lastDay ".$lastDay."";
	
	//     # MONTH - Flexible Month
	//     $firstDay = new Carbon\Carbon('first day of -2 month'); # previous last 2 months from current month
	//     $lastDay = new Carbon\Carbon('last day of +2 month'); # next 2 months from current month
	//     // return "Flexible Month: firstDay ".$firstDay." --- lastDay ".$lastDay."";
	
	//     # MONTH 2 - Previous Month
	//     $monthStart = Carbon\Carbon::now()->subMonths(1)->startOfMonth();
	//     $monthEnd = Carbon\Carbon::now()->subMonths(1)->endOfMonth(); # position important for this chain
	//     // return "Previous Month: monthStart ".$monthStart." --- monthEnd ".$monthEnd."";
	
	//     # MONTH 2 - Current Month
	//     $monthStart = Carbon\Carbon::now()->startOfMonth(); # first day of this month
	//     $monthEnd = Carbon\Carbon::now()->endOfMonth(); # end day of this month
	//     // return "Current Month: monthStart ".$monthStart." --- monthEnd ".$monthEnd."";
	
	//     # MONTH 2 - Next Month
	//     $monthStart = Carbon\Carbon::now()->addMonths(1)->startOfMonth();
	//     $monthEnd = Carbon\Carbon::now()->addMonths(1)->endOfMonth(); # position important for this chain
	//     // return "Next Month: monthStart ".$monthStart." --- monthEnd ".$monthEnd."";
	
	
		  // function scopeThisWeek($query)
		  // {
		  //   $date = Carbon::parse('this sunday')->toDateString();
		  //   return $query->where('start_date', '<', $date);
		  // }
		  // function scopeNextWeek($query)
		  // {
		  //   $sdate = Carbon::parse('this monday')->toDateString();
		  //   $edate = Carbon::parse('next sunday')->toDateString();
		  //   return $query->where('start_date', '>', $sdate, 'and')->where('start_date', '<', $edate);
		  // }
		  // function scopeUpcoming($query)
		  // {
		  //   $date = Carbon::parse('next monday')->toDateString();
		  //   return $query->where('start_date', '>', $date);
		  // }      
	// });
	
	// Route::get('/raw', function(){
	
	//   # Using Model
	//   return $notices = App\Model\Mutation\Record\Game::
	//   # Without Model
	//   //return $notices = DB::table('mutation_record_game')->
	//   join(
	//       'mutation_record_mission', function ($join) {
	//           $join->on('mutation_record_game.code_user', '=', 'mutation_record_mission.code_user')
	//                ->on('mutation_record_game.code_mission', '=', 'mutation_record_mission.code_mission')
	//                ->where('mutation_record_game.status', '=', 'enable')
	//                # current month
	//                # ->where('created_at', '>=', Carbon::now()->startOfMonth())->get()
	//                # ->where( DB::raw('MONTH(created_at)'), '=', date('n') )->get()
	//                ;   
	//       }
	//   )->
	//   select(
	//       DB::raw("
	//         `mutation_record_game`.`code_user` AS `code_user_game`,
	//         # `mutation_record_mission`.`code_user` AS `code_user_mission`,
	//         # `mutation_record_mission`.`code_mission` AS `code_mission`,
	//         # `mutation_record_game`.`code_game` AS `code_game`,
	//         Sum(`mutation_record_game`.`cash`) AS `game_cash`,
	//         Sum(`mutation_record_game`.`coin`) AS `game_coin`,
	//         Sum(`mutation_record_game`.`score`) AS `game_score`,
	//         Sum(`mutation_record_game`.`overtime`) AS `game_overtime`,
	//         Sum(`mutation_record_mission`.`cash`) AS `mission_cash`,
	//         Sum(`mutation_record_mission`.`coin`) AS `mission_coin`,
	//         Sum(`mutation_record_mission`.`score`) AS `mission_score`,        
	
	//         `mutation_record_game`.`created_at` AS `created_at`,
	//         Group_Concat(DISTINCT `mutation_record_game`.`status`) as status        
	//       ")
	//   )->
	//   groupBy('mutation_record_game.code_user')->
	//   orderBy('mutation_record_game.code_user', 'desc')->
	//   paginate(2);
	
	
	//   $results = DB::select("
	//   SELECT
	//       `mutation_record_game`.`code_user` AS `code_user_game`,
	//       `mutation_record_mission`.`code_user` AS `code_user_mission`,
	//       `mutation_record_mission`.`code_mission` AS `code_mission`,
	//       `mutation_record_game`.`code_game` AS `code_game`,
	//       Sum(`mutation_record_game`.`cash`) AS `game_cash`,
	//       Sum(`mutation_record_game`.`coin`) AS `game_coin`,
	//       Sum(`mutation_record_game`.`score`) AS `game_score`,
	//       Sum(`mutation_record_game`.`overtime`) AS `game_overtime`,
	//       Sum(`mutation_record_mission`.`cash`) AS `mission_cash`,
	//       Sum(`mutation_record_mission`.`coin`) AS `mission_coin`,
	//       Sum(`mutation_record_mission`.`score`) AS `mission_score`
	//   FROM
	//       `mutation_record_game`
	//       INNER JOIN `mutation_record_mission` ON `mutation_record_mission`.`code_user`
	//         = `mutation_record_game`.`code_user` AND
	//         `mutation_record_mission`.`code_mission` =
	//         `mutation_record_game`.`code_mission`
	//   GROUP BY
	//       `mutation_record_game`.`code_user`
	//   LIMIT 1, 2
	//   ");
	
	//   return DB::table('mutation_record_game')
	//   ->select(
	//       DB::raw("
	//         `mutation_record_game`.`code_user`,
	//         `mutation_record_game`.`code_game`,
	//         Sum(`mutation_record_game`.`cash`) as cash,
	//         Sum(`mutation_record_game`.`coin`) as coin,
	//         Sum(`mutation_record_game`.`score`) as score,
	//         Sum(`mutation_record_game`.`overtime`) as overtime,
	//         Group_Concat(DISTINCT `mutation_record_game`.`status`) as status
	//       ")
	//   )
	//   ->groupBy('code_user')
	//   ->orderBy('code_user', 'desc')
	//   ->paginate(1);
	
	
	//   $results = DB::select("
	//       SELECT
	//         `mutation_record_game`.`code_user`,
	//         `mutation_record_game`.`code_game`,
	//         Sum(`mutation_record_game`.`cash`) as cash,
	//         Sum(`mutation_record_game`.`coin`),
	//         Sum(`mutation_record_game`.`score`),
	//         Sum(`mutation_record_game`.`overtime`),
	//         Group_Concat(DISTINCT `mutation_record_game`.`status`)
	//       FROM
	//         `mutation_record_game`
	//       GROUP BY
	//         `mutation_record_game`.`code_user`
	//       LIMIT 7
	//   ");
	 
	//   return response()->json(compact("results"));
	
	
	
	//   return DB::raw(
	//     "
	//     SELECT
	//     'mutation_record_game.code_user AS code_user_game',
	//     'mutation_record_mission.code_user AS code_user_mission',
	//     'mutation_record_mission.code_mission AS code_mission',
	//     'mutation_record_game.code_game AS code_game',
	
	//     Sum('mutation_record_game.cash') AS 'game_cash',
	//     Sum('mutation_record_game.coin') AS 'game_coin',
	//     Sum('mutation_record_game.score') AS 'game_score',
	//     Sum('mutation_record_game.overtime') AS 'game_overtime',
	//     Sum('mutation_record_mission.cash') AS 'mission_cash',
	//     Sum('mutation_record_mission.coin') AS 'mission_coin',
	//     Sum('mutation_record_mission.score') AS 'mission_score'
	//   FROM
	//     'mutation_record_game'
	//     INNER JOIN 
	//       'mutation_record_mission' ON 
	//         'mutation_record_mission.code_user' = 'mutation_record_game.code_user' 
	//         AND
	//         'mutation_record_mission.code_mission' = 'mutation_record_game.code_mission'
	//   GROUP BY
	//     'mutation_record_game.code_user'
	//   LIMIT 7;  
	//     "
	//   )->get();
	// });
	


// Route::group(['prefix' => 'library', 'as' => 'library.', 'namespace' => 'Library', 'middleware' => 'cors'], function(){
//   Route::resource('achievement', 'AchievementController');
//   Route::resource('bonus', 'FreebiesController');
//   Route::resource('freebies', 'FreebiesController');
//   Route::resource('intro', 'IntroController');
//   Route::resource('limit', 'LimitController');
//   Route::resource('mission', 'MissionController');
//   Route::resource('purchase', 'PurchaseController');
//   Route::resource('tools', 'ToolsController');
//   Route::resource('vehicle', 'VehicleController');
//   Route::resource('withdraw', 'WithdrawController');
// });

// Route::group(['prefix' => 'mutation', 'as' => 'mutation.', 'namespace' => 'Mutation'], function(){
//   Route::group(['prefix' => 'record', 'as' => 'record.', 'namespace' => 'Record'], function(){
//     Route::resource('achievement', 'AchievementController');
//     Route::resource('bonus', 'BonusController');
//     Route::resource('freebies', 'FreebiesController');
//     Route::resource('game', 'GameController');
//     Route::resource('mission', 'MissionController');
//     Route::resource('purchase', 'PurchaseController');
//     Route::resource('withdraw', 'WithdrawController');
//   });
//   Route::group(['prefix' => 'reference', 'as' => 'reference.', 'namespace' => 'Reference'], function(){
//     Route::resource('intro', 'IntroController');
//     Route::resource('tools', 'ToolsController');
//     Route::resource('vehicle', 'VehicleController');
//   });
// });

// Route::group(['prefix' => 'general', 'as' => 'general.', 'namespace' => 'General'], function(){
//   Route::resource('faq', 'FaqController');
//   Route::resource('schedule', 'ScheduleController');
// });

// Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function(){
//   Route::resource('user', 'UserController');
//   Route::resource('user_profile', 'UserProfileController');
// });

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
