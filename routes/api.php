<?php

use Illuminate\Http\Request;

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


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\UserController@login');
    Route::post('signup', 'Api\UserController@signup');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Api\UserController@logout');
        Route::get('user', 'Api\UserController@user');
        Route::post('update', 'Api\UserController@update');
    });
});

Route::fallback(function(){
    return response()->json(['error' => "url not found" , 'status' => 0] , 404);
});
Route::middleware(['auth:api' , 'useractive'])->prefix('/user')->group(function () {
    Route::post('update', 'Api\UserController@updateProfile');
    
    Route::get('/data/{minute?}/{hour?}/{day?}' , 'user_bpms@user_api_data');
    Route::get('/{user}/data/{minute?}/{hour?}/{day?}' , 'user_bpms@friend_api_data');
    Route::get("/bpms", "user_bpms@show");
    Route::get("/temps", "user_temps@show");
    // heart bpms
    Route::prefix('/bpm')->group(function () {
        Route::post("/{bpm}", "user_bpms@insert")->where([
            "bpm" => "[0-9]+"
        ]);
        Route::prefix('/last')->group(function () {
            // last element stored in db
            Route::get("/", "user_bpms@last");
            // last bpms in last minute
            Route::get("/minute/{time?}", "user_bpms@lastMinute");
            // last bpms in last Hour
            Route::get("/hour/{time?}", "user_bpms@lastHour");
            // last bpms in last Day
            Route::get("/day/{time?}", "user_bpms@lastDay");
            Route::get("/all", "user_bpms@all");
        });
    });
    // tempretaure
    Route::prefix('/temp')->group(function () {
        Route::post("/{temp}", "user_temps@insert")->where([
            "temp" => "[0-9]+"
        ]);
        Route::prefix('/last')->group(function () {
            // last element stored in db
            Route::get("/", "user_temps@last");
            // last bpms in last minute
            Route::get("/minute/{time?}", "user_temps@lastMinute");
            // last bpms in last Hour
            Route::get("/hour/{time?}", "user_temps@lastHour");
            // last bpms in last Day
            Route::get("/day/{time?}", "user_temps@lastDay");
            Route::get("/all", "user_temps@all");
        });
    });
});
