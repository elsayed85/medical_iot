<?php

use App\bpm;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home2');
})->name("/");

Route::get("/team" , function(){
    return view('team');
});
Route::get('/login2' , function(){
    return view('auth.login2');
});


Route::middleware("auth")->group(function () {

    // user profile
    Route::get("/profile", "userController@profile")->name("user_profile"); // auth user
    Route::get("/user/{id}" , 'userController@userprofile')->name("user_profile2"); // for normal user profile
    Route::post("/user/{id}" , 'userController@adduser')->name("adduser"); // for normal user profile
    Route::delete("/user/{id}" , 'userController@removeuser')->name("removeuser"); // for normal user profile
    Route::get("/family" , 'userController@family')->name('family');
    Route::post("/profile", "userController@updateProfile")->name("update_profile");
    Route::get("/search" ,'userController@search')->name('search');
    Route::resource("/doctor" , "user_doctors");
    Route::get('/api' , 'userController@api_route')->name('user_api');
    // user heart model
    Route::middleware("useractive")->get("/heart", "userController@heartModel")->name('heartModel');
    // user data as pdf
    Route::get("/data", "userController@data")->name('healt_report');
});

Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
