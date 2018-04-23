<?php

use Illuminate\Http\Request;
use App\Model\User\GetSummary;

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Authenticate'], function(){
  Route::get('auth', 'AuthController@index');
  Route::post('auth', 'AuthController@index');
});

# Library
  Route::group(['prefix' => 'library', 'as' => 'library.', 'namespace' => 'Library'], function(){
    Route::resource('achievement', 'AchievementController');
    Route::resource('bonus', 'BonusController');
    Route::resource('freebies', 'FreebiesController');
    Route::resource('intro', 'IntroController');
    Route::resource('limit', 'LimitController');
    Route::resource('mission', 'MissionController');
    Route::resource('purchase', 'PurchaseController');
    Route::resource('tools', 'ToolsController');
    Route::resource('vehicle', 'VehicleController');
    Route::resource('withdraw', 'WithdrawController');
    Route::get('reset/mission', 'MissionController@reset');
  });
Route::group(['middleware' => ['buster','auth:api']], function(){       
});

Route::group(['middleware' => ['auth:api','sentry']], function(){       
  Route::group(['prefix' => 'mutation', 'as' => 'mutation.', 'namespace' => 'Mutation'], function(){
    Route::group(['prefix' => 'record', 'as' => 'record.', 'namespace' => 'Record'], function(){
      Route::resource('achievement/active', 'AchievementController');
      Route::resource('bonus/active', 'BonusController');
      Route::resource('freebies/active', 'FreebiesController');
      Route::resource('game/active', 'GameController');
      Route::resource('user/active', 'UserController');
      Route::resource('mission/active', 'MissionController');
      Route::resource('purchase/active', 'PurchaseController');
      Route::resource('withdraw/active', 'WithdrawController');
      Route::resource('tools/active', 'ToolsController');
      Route::resource('vehicle/active', 'VehicleController');
    });
  });
  Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function(){
    Route::resource('user', 'UserController');
    Route::resource('user_record_earning', 'UserRecordEarningController');
  });
});


# Mutation
Route::group(['middleware' => ['buster','auth:api','sentry']], function(){       
  //['auth:api,scope:player,admin']
  Route::group(['prefix' => 'mutation', 'as' => 'mutation.', 'namespace' => 'Mutation'], function(){
    Route::group(['prefix' => 'record', 'as' => 'record.', 'namespace' => 'Record'], function(){
      Route::resource('achievement', 'AchievementController');
      Route::resource('bonus', 'BonusController');
      Route::resource('freebies', 'FreebiesController');
      Route::resource('game', 'GameController');
      Route::resource('user', 'UserController');
      Route::resource('mission', 'MissionController');
      Route::resource('purchase', 'PurchaseController');
      Route::resource('withdraw', 'WithdrawController');
      Route::resource('tools', 'ToolsController');
      Route::resource('vehicle', 'VehicleController');
    });

    Route::group(['prefix' => 'reference', 'as' => 'reference.', 'namespace' => 'Reference'], function(){
      Route::resource('intro', 'IntroController');
    });    
    Route::group(['prefix' => 'resume', 'as' => 'resume.', 'namespace' => 'Resume'], function(){
      Route::get('/{query?}', 'ResumeController@index');
      Route::get('/show/{id?}', 'ResumeController@show');
    });    
  });
  // Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function(){
  //   // Route::resource('user', 'UserController',  ['except' => 'show,index']);
  //   Route::resource('user', 'UserController');
  //   Route::resource('user_record_earning', 'UserRecordEarningController');
  // });
  
});


// Route::get('jojon', function () {
//     return $s = App\Model\User\PostSummary::all();
// });

# For Game
Route::group(['prefix' => 'game', 'as' => 'game.', 'namespace' => 'Mutation\Game'], function(){
  Route::resource('history', 'HistoryController', ['only' => ['show']]);
  Route::resource('entry', 'EntryController');
  Route::resource('availability/{code_user}', 'AvailabilityController', ['only' => ['index']]);
  Route::resource('dashboard/{code_user}', 'AvailabilityController', ['only' => ['index']]);
  //Route::resource('achievement', 'AchievementController', ['only' => ['index']]);
});    

# tidak akan dipakai
Route::resource('achievement/unsecure', 'Library\AchievementController');
Route::group(['prefix' => 'mutation', 'as' => 'reference.', 'namespace' => 'Mutation'], function(){
    Route::group(['prefix' => 'record', 'as' => 'record.', 'namespace' => 'Record'], function(){
	  Route::resource('achievement/unsecure', 'AchievementController');
	  Route::resource('bonus/unsecure', 'BonusController');
	  Route::resource('freebies/unsecure', 'FreebiesController');
	  Route::resource('game/unsecure', 'GameController');
	  Route::resource('user/unsecure', 'UserController');
	  Route::resource('mission/unsecure', 'MissionController');
	  Route::resource('purchase/unsecure', 'PurchaseController');
	  Route::resource('withdraw/unsecure', 'WithdrawController');
	  Route::resource('tools/unsecure', 'ToolsController');
	  Route::resource('vehicle/unsecure', 'VehicleController');
	});    
});    


