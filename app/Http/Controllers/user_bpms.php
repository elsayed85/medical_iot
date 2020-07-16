<?php

namespace App\Http\Controllers;

use App\bpm;
use App\User;
use App\user_temp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class user_bpms extends Controller
{
    public function __construct()
    {
       $this->middleware('client.credentials');
    }
    private $def =  [
        "last" =>   [],
        "day" =>    [],
        "hour" =>    [],
        "minute" =>  [],
        "info" => [
            "day" => [
                "min" => 0,
                "max" => 0
            ],
            "hour" => [
                "min" => 0,
                "max" => 0
            ],
            "minute" => [
                "min" => 0,
                "max" => 0
            ],
        ]
    ];
    
    public function insert($bpm)
    {
        $user = Auth::user();
        if ($user->state == 1) {
            // user if found & active
            $bpm_obj = new bpm();
            $bpm_obj->user_id = $user->id;
            if($bpm < 0){
                return response()->json(['status' => 0 , 'message' => 'bpm < 0' , 'user_state' => 'active'], 404);
            }
            $bpm_obj->bpm =  $bpm;
            $bpm_obj->save();
            return response()->json(['status' => 1, 'message' => 'created' , 'user_state' => 'active'], 201);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active'], 404);
        }
    }
    public function show()
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            $bpms = bpm::where('user_id', $id)->orderBy("created_at", 'desc')->get();
            return response()->json(['data' => $bpms , 'status' => 1], 201);
        } else {
            // user not found || not active
            return response()->json(['message' => 'failed', 'user_state' => 'not active or not found'], 404);
        }
    }
    public function last()
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $bpm = bpm::where('user_id', $id)->orderBy("created_at", 'desc')->first();
            return response()->json(['last' => $bpm , 'status' => 1], 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed', 'user_state' => 'not active or not found'], 404);
        }
    }
    public function lastMinute($minute = 1)
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $last_bpm = bpm::where("user_id" , $id)->latest()->first();
            if (!is_null($last_bpm)) {
                $last_bpm = $last_bpm->created_at->toDateTimeString();
                $last_bpm = bpm::latest()->first()->created_at->toDateTimeString();
                $sub_minute  =  Carbon::create($last_bpm)->subMinutes($minute)->format("Y-m-d H:i:s");
                $ele = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                return response()->json(['avg' => $ele , 'time' => $minute , 'type' => 'minutes' , 'status' => 1], 200);
            }
            return response()->json(['avg' => 0 , 'time' => $minute , 'type' => 'minutes' , 'message' => 'no data' , 'status' => 0 ] , 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active or not found'], 404);
        }
    }
    public function lastHour($hour = 1)
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $last_bpm = bpm::where("user_id" , $id)->latest()->first();
            if (!is_null($last_bpm)) {
                $last_bpm = $last_bpm->created_at->toDateTimeString();
                $sub_hour  =  Carbon::create($last_bpm)->subHours($hour)->format("Y-m-d H:i:s");
                $ele = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_hour, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                return response()->json(['avg' => $ele , 'time' => $hour , 'type' => 'hours' ,  'status' => 1], 200);
            }
            return response()->json(['avg' => 0 , 'time' => $hour , 'type' => 'hours' , 'message' => 'no data' , 'status' => 0 ] , 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active or not found'], 404);
        }
    }
    public function lastDay($day = 1)
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $last_bpm = bpm::where("user_id" , $id)->latest()->first();
            //dd($last_bpm);
            if (!is_null($last_bpm)) {
                $last_bpm = $last_bpm->created_at->toDateTimeString();
                $sub_Day  =  Carbon::create($last_bpm)->subDays($day)->format("Y-m-d H:i:s");
                $ele = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                return response()->json(['avg' => $ele , 'time' => $day , 'type' => 'days' , 'status' => 1], 200);
            }
            return response()->json(['avg' => 0 , 'time' => $day ,'type' => 'days' , 'message' => 'no data' , 'status' => 0 ] , 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active or not found'], 404);
        }
    }
    public function all()
    {
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date 
            $last_bpm = bpm::where("user_id" , $id)->latest()->first();
            if (!is_null($last_bpm)) {
                $last_bpm = $last_bpm->created_at->toDateTimeString();
                $sub_Day  =  Carbon::create($last_bpm)->subDay()->format("Y-m-d H:i:s");
                $sub_hour  =  Carbon::create($last_bpm)->subHour()->format("Y-m-d H:i:s");
                $sub_minute  =  Carbon::create($last_bpm)->subMinute()->format("Y-m-d H:i:s");
                $lastDay = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_bpm])->orderBy("created_at", 'desc')->get();
                // $lastDay['min'] = collect($lastDay)->min("bpm");
                // $lastDay['max'] = collect($lastDay)->max("bpm");
                $lastHour = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_hour, $last_bpm])->orderBy("created_at", 'desc')->get();
                // $lastHour['min'] = collect($lastHour)->min("bpm");
                // $lastHour['max'] = collect($lastHour)->max("bpm");
                $lastMinute = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_bpm])->orderBy("created_at", 'desc')->get();
                // $lastMinute['min'] = collect($lastMinute)->min("bpm");
                // $lastMinute['max'] = collect($lastMinute)->max("bpm");
                $last_sec = bpm::where('user_id', $id)->orderBy("created_at", 'desc')->first();
                $arr = [
                    "last" =>   $last_sec,
                    "day" =>    $lastDay,
                    "hour" =>    $lastHour,
                    "minute" =>  $lastMinute,
                    "info" => [
                        "day" => [
                            "min" => collect($lastDay)->min("bpm"),
                            "max" => collect($lastDay)->max("bpm")
                        ],
                        "hour" => [
                            "min" => collect($lastHour)->min("bpm"),
                            "max" => collect($lastHour)->max("bpm")
                        ],
                        "minute" => [
                            "min" => collect($lastMinute)->min("bpm"),
                            "max" => collect($lastMinute)->max("bpm")
                        ],
                    ]
                ];
                return response()->json(['data' => $arr , 'status' => 1], 200);
            }
            return response()->json(['data'=>$this->def ,  'status' => 0 , 'message' => 'no data' ], 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active or not found'], 404);
        }
    }
    
    public function user_api_data($minute = 1 , $hour = 1 , $day = 1){
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $bpm = bpm::where('user_id', $id)->orderBy("created_at", 'desc');
            $temp = user_temp::where('user_id', $id)->orderBy("created_at", 'desc');
            if (!is_null($bpm)) {
                $last_bpm = $bpm->first()->created_at->toDateTimeString();
                $sub_hour  =  Carbon::create($last_bpm)->subHours($hour)->format("Y-m-d H:i:s");
                $bpm_hours = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_hour, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                
                $sub_minute  =  Carbon::create($last_bpm)->subMinutes($minute)->format("Y-m-d H:i:s");
                $bpm_minutes = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                
                $sub_Day  =  Carbon::create($last_bpm)->subDays($day)->format("Y-m-d H:i:s");
                $bpm_days = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                
                
                
                $last_temp = $temp->first()->created_at->toDateTimeString();
                $sub_hour  =  Carbon::create($last_temp)->subHours($hour)->format("Y-m-d H:i:s");
                $temp_hours = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_hour, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                
                $sub_minute  =  Carbon::create($last_temp)->subMinutes($minute)->format("Y-m-d H:i:s");
                $temp_minutes = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                
                $sub_Day  =  Carbon::create($last_temp)->subDays($day)->format("Y-m-d H:i:s");
                $temp_days = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                
                return response()->json([
                    'bpm' => [
                        'last' => $bpm->first() ,
                        'avg' => [
                            'minute' => ['value' => round($bpm_minutes,2) , 'time' => $minute],
                            'hour' => ['value' => round($bpm_hours,2) , 'time' => $hour],
                            'day' => ['value' => round($bpm_days,2) , 'time' => $day]
                        ],
                        'count' => $bpm->count()
                    ],
                    'temp' => [
                        'last' => $temp->first() ,
                        'avg' => [
                            'minute' => ['value' => round($temp_minutes,2) , 'time' => $minute],
                            'hour' => ['value' => round($temp_hours,2) , 'time' => $hour],
                            'day' => ['value' => round($temp_days,2) , 'time' => $day]
                        ],
                        'count' => $temp->count()
                    ],
                    'status' => 1
                ], 200);
            }
            return response()->json(['status' => 0 , 'message' => 'no data'], 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active or not found'], 404);
        }
    }
    public function friend_api_data($user_id , $minute = 1 , $hour = 1 , $day = 1){
        $user = User::find($user_id);
        if(is_null($user)){
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'user not found'], 404);
        }
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $bpm = bpm::where('user_id', $id)->orderBy("created_at", 'desc');
            $temp = user_temp::where('user_id', $id)->orderBy("created_at", 'desc');
            if (!is_null($bpm)) {
                $last_bpm = $bpm->first()->created_at->toDateTimeString();
                $sub_hour  =  Carbon::create($last_bpm)->subHours($hour)->format("Y-m-d H:i:s");
                $bpm_hours = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_hour, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                
                $sub_minute  =  Carbon::create($last_bpm)->subMinutes($minute)->format("Y-m-d H:i:s");
                $bpm_minutes = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                
                $sub_Day  =  Carbon::create($last_bpm)->subDays($day)->format("Y-m-d H:i:s");
                $bpm_days = bpm::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
                
                
                
                $last_temp = $temp->first()->created_at->toDateTimeString();
                $sub_hour  =  Carbon::create($last_temp)->subHours($hour)->format("Y-m-d H:i:s");
                $temp_hours = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_hour, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                
                $sub_minute  =  Carbon::create($last_temp)->subMinutes($minute)->format("Y-m-d H:i:s");
                $temp_minutes = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                
                $sub_Day  =  Carbon::create($last_temp)->subDays($day)->format("Y-m-d H:i:s");
                $temp_days = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                
                return response()->json([
                    'bpm' => [
                        'last' => $bpm->first() ,
                        'avg' => [
                            'minute' => ['value' => round($bpm_minutes,2) , 'time' => $minute],
                            'hour' => ['value' => round($bpm_hours,2) , 'time' => $hour],
                            'day' => ['value' => round($bpm_days,2) , 'time' => $day]
                        ],
                        'count' => $bpm->count()
                    ],
                    'temp' => [
                        'last' => $temp->first() ,
                        'avg' => [
                            'minute' => ['value' => round($temp_minutes,2) , 'time' => $minute],
                            'hour' => ['value' => round($temp_hours,2) , 'time' => $hour],
                            'day' => ['value' => round($temp_days,2) , 'time' => $day]
                        ],
                        'count' => $temp->count()
                    ],
                    'status' => 1
                ], 200);
            }
            return response()->json(['status' => 0 , 'message' => 'no data'], 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active or not found'], 404);
        }
    }
}
