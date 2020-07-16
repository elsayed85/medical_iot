<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\ApiController;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends ApiController
{

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        /*
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'numeric', 'min:1', 'max:100'],
            'geneder' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4']
        ]);
        */
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'numeric', 'min:1', 'max:100'],
            'geneder' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4']
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors() , 'status' => 0], 401);
        }
        $gen = $request->geneder;
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'geneder' => ($gen == "male" || $gen == "female") ? $gen : "male",
            'age' => $request->age,
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!',
            'status' => 1
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors() , 'status' => 0], 401);
        }
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 0
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $user->api_token = $tokenResult->accessToken;
        $user->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'status' => 1
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
            'status' => 1
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json(['data' => collect($request->user())->except(['api_token' , 'created_at' , 'provider' , 'provider_id' , 'email_verified_at']) , 'status' => 1]);
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|max:30|confirmed',
            'state' => 'in:' . User::VERFIED_USER . ',' . User::UNVERFIED_USER,
            'start_sleep' => "nullable|date_format:H:i",
            'end_sleep' => "nullable|date_format:H:i",
            'age' => ['numeric', 'min:1' , 'max:120'],
            'weight' => 'numeric',
            'phone' => "numeric|min:6",
            'facebook' => "string"
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors() , 'status' => 0], 401);
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email') && $user->email != $request->email) {
            $user->state = User::UNVERFIED_USER;
            $user->email = $request->email;
        }
        if($request->has('age')){
            $user->age = $request->age;
        }
        if($request->has('weight')){
            $user->weight = $request->weight;
        }
        if($request->has('phone')){
            $user->phone = $request->phone;
        }
        if($request->has('start_sleep')){
            $user->start_sleep = $request->start_sleep;
        }
        if($request->has('end_sleep')){
            $user->end_sleep = $request->end_sleep;
        }
        if($request->has('geneder')){
            $user->geneder = $request->geneder;
        }
        if($request->has('facebook')){
            $user->facebook = $request->facebook;
        }
        if($request->has('heart_audio')){
            $user->heart_audio = $request->heart_audio;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('state')) {
            if (!$user->isaVerified()) {
                return $this->errorResponse('only verfied users can do this action', 409);
            }
            $user->state = $request->state;
        }
        // if nothing changed
        if(!$user->isDirty()){
            return $this->errorResponse('you must change some values to update', 422);
        }
        $user->save();
        return response()->json(['data' => collect($user)->except(['api_token' , 'created_at' , 'provider' , 'provider_id' , 'email_verified_at']) , 'status' => 1] , 201);;
    }
}
