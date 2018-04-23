<?php

	function Requests(Illuminate\Http\Request $request, $dispatcher = null)
	{		
		switch ($dispatcher) {
			case 'player':
				# New Player by Admin 
				event(new RegisterEvent($target = $request->value));
				return Sentinel::Player($request);
				break;
			case 'register':
				# Authenticate
				# Email
				// return $request->email;
				event(new RegisterEvent($target = $request->value));
				return Sentinel::Register($request);
				break;
			case 'login':
				# Authenticate
				# No Email
				event(new LoginEvent($target = $request->value));
				return Sentinel::Login($request);
				break;
			case 'forget':
				# Authenticate
				# Email
				event(new ForgetEvent($target = $request->value));
				return Sentinel::Forget($request);
				break;
			case 'reset':
				# Authenticate
				# currently unused in game
				# chained with Guardian Middleware
				# reset is a link that auto authenticate when clicking by user
				# only JWT Guard without Passport
				# this is GET
				event(new ResetEvent());
				return Sentinel::Reset($request);
				break;
			default:
				return responses('share Requests error');
				break;
		}
	}
	
	function New_Wallet($code_user){
		return ($code_user);

	}


	function Today_Of_Week()
	{
		return \Carbon\Carbon::now()->dayOfWeek;
	}

	function Day_Of_Week($day)
	{
		return \Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays($day)->subDays(1)->toDateString();
	}
	
	# next week of maintenance
	function Next_Week($day){
		return \Carbon\Carbon::now()->startOfWeek()->addWeeks(1)->addDays($day)->subDays(1)->toDateString();
	}

	# this week of maintenance
	function This_Week($day){
		return \Carbon\Carbon::now()->startOfWeek()->addWeeks(0)->addDays($day)->subDays(1)->toDateString();
	}
	
	function On_This_Week(){
		return Carbon\Carbon::now()->startOfWeek()->subDays(1)->toDateString();
	}

	function Calculation_Start_Finish($start, $finish)
    {
		$to_time = strtotime($finish);
        $from_time = strtotime($start);
        $minutes = ($to_time - $from_time) / 60; 
        
		return ($minutes < 0 ? 0 : abs($minutes));   
    }	
	
	function Calculation_Now($start, $finish)
    {
		$to_time = strtotime($start);
        $from_time = strtotime($finish);
        $minutes = ($to_time - $from_time) / 60; 
        
		return ($minutes < 0 ? 0 : abs($minutes));   
    }	
	
	# import to Bridge
	function Timechecker(...$payload)
	{
		$interval = $payload[0][0]; 
		$finish = $payload[0][1]['finish']; 
		$start = $payload[0][1]['start']; 
		
		$time = calculation_start_finish($start, $finish);
	
		return $time >= $interval ? [
			'label' => 'high', 
			'time' => $time, 
			'start' => $start,
			'finish' => $finish,
			'note' => 'Your data updated successfully',
		] : [
			'label' => 'low', 
			'time' => $time, 
			'start' => $start,
			'finish' => $finish,
			'note' => 'Finsih time is '.$finish.' - Start time is '.$start.' does not pass minimum 120 minutes requirement. Please fix it...',
		];			
	}

	function ResetMission()
	{

		$mission = App\Model\Library\PostMission::class;

		for ($i = 0; $i < count($mission::pluck('id')); $i++) { 

			$hours = mt_rand(1, 23);
			$minutes = mt_rand(1, 59);

			$mission::whereId($i+1)->update([
				'timer' => date('Y-m-d '.$hours.':'.$minutes.':s')
			]);

		}

		return 'updated mission';

	}
?>