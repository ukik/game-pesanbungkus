<?php

use Illuminate\Database\Seeder;

# php artisan db:seed --class=MaintenanceTableSeeder

class MaintenanceTableSeeder extends Seeder
{

  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('library_maintenance')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');      
  
    $faker = Faker\Factory::create();

    $conditional = ['this','next'];

	//$timestamp = mt_rand(1, 2147385600);	
	
    for ($i=0; $i < count($conditional); $i++) { 
      # code...
	  
	  if($i == 0){
			$day = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
		  DB::table('library_maintenance')->insert(
			[
			  'code_maintenance' => $faker->uuid,
			  'title' => $faker->realText($maxNbChars = 10, $indexSize = 2),
			  'due' => Carbon\Carbon::now()->parse('next '.$day[array_rand($day)])->addWeeks(0)->toDateString(),
			  'day' => $day[array_rand($day)],
			  'start' => date("h:i", mt_rand(1, time())), 
			  'finish' => date("23:i", mt_rand(1, time())),
			  'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
			  'control' => $conditional[$i],
			]
		  );		  
	  }
	  if($i == 1){
			$day = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
		  DB::table('library_maintenance')->insert(
			[
			  'code_maintenance' => $faker->uuid,
			  'title' => $faker->realText($maxNbChars = 10, $indexSize = 2),
			  'due' => Carbon\Carbon::now()->parse('next '.$day[array_rand($day)])->addWeeks(1)->toDateString(),
			  'day' => $day[array_rand($day)],
			  'start' => date("h:i", mt_rand(1, time())), 
			  'finish' => date("23:i", mt_rand(1, time())),
			  'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
			  'control' => $conditional[$i],
			]
		  );		  
	  }
	}
  }
}
