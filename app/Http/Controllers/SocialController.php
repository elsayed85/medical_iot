<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Response, File;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        $email = $getInfo->getEmail();
        if (User::where('email', $email)->count() > 0) {
            // log them in
            $user = User::where('email', $email)->first();
            $user->api_token = Str::random(80);
            $user->avatar = $getInfo->avatar_original;
            $user->provider = $provider;
            $user->provider_id = $getInfo->id;
            $user->save();
            auth()->login($user->first());
            return redirect()->to('/profile');
        } else {
            $user = $this->createUser($getInfo, $provider);
            auth()->login($user);
            return redirect()->to('/profile');
        }

    }
    function createUser($getInfo, $provider)
    {
        $user = User::where('provider_id', $getInfo->id)->where('email', $getInfo->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $getInfo->name;
            $user->email = $getInfo->email;
            $user->password = Hash::make($getInfo->email);
            $user->api_token = Str::random(80);
            $user->provider = $provider;
            $user->provider_id = $getInfo->id;
            $user->avatar = $getInfo->avatar_original;
            $user->save();
        }
        return $user;
    }
}
