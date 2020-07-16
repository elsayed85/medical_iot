<?php

namespace App\Http\Controllers;

use App\User;
use App\user_temp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class user_temps extends Controller
{
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
    public function insert($temp)
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // user if found & active
            if($temp < 0){
                return response()->json(['status' => 0 , 'message' => 'temp < 0' , 'user_state' => 'active'], 404);
            }
            $tmp_obj = new user_temp();
            $tmp_obj->user_id = $id;
            $tmp_obj->temp =  $temp;
            $tmp_obj->save();
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
            $temps = user_temp::where('user_id', $id)->orderBy("created_at", 'desc')->get();
            return response()->json(['data' => $temps , 'status' => 1], 201);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active'], 404);
        }
    }
    public function last()
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $temp = user_temp::where('user_id', $id)->orderBy("created_at", 'desc')->first();
            return response()->json(['last' => $temp , 'status' => 1], 201);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active'], 404);
        }
    }
    public function lastMinute($minute = 1)
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $last_temp = user_temp::where("user_id" , $id)->latest()->first();
            if (!is_null($last_temp)) {
                $last_temp = $last_temp->created_at->toDateTimeString();
                $sub_minute  =  Carbon::create($last_temp)->subMinutes($minute)->format("Y-m-d H:i:s");
                $ele = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                return response()->json(['avg' => $ele , 'time' => $minute , 'type' => 'minutes' , 'status' => 1], 200);
            }
            return response()->json(['avg' => 0 , 'time' => $minute , 'type' => 'minutes' , 'message' => 'no data' , 'status' => 0 ] , 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active'], 404);
        }
    }
    public function lastHour($hour = 1)
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $last_temp = user_temp::where("user_id" , $id)->latest()->first();
            if (!is_null($last_temp)) {
                $last_temp = $last_temp->created_at->toDateTimeString();
                $sub_minute  =  Carbon::create($last_temp)->subHours($hour)->format("Y-m-d H:i:s");
                $ele = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                return response()->json(['avg' => $ele , 'time' => $hour , 'type' => 'hours' ,  'status' => 1], 200);
            }
            return response()->json(['avg' => 0 , 'time' => $hour , 'type' => 'hours' , 'message' => 'no data' , 'status' => 0 ] , 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active'], 404);
        }
    }
    public function lastDay($day = 1)
    {
        // check if user is active
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date
            $last_temp = user_temp::where("user_id" , $id)->latest()->first();
            if (!is_null($last_temp)) {
                $last_temp = $last_temp->created_at->toDateTimeString();
                $sub_Day  =  Carbon::create($last_temp)->subDays($day)->format("Y-m-d H:i:s");
                $ele = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_temp])->orderBy("created_at", 'desc')->avg('temp');
                return response()->json(['avg' => $ele , 'time' => $day , 'type' => 'days' , 'status' => 1], 200);
            }
            return response()->json(['avg' => 0 , 'time' => $day ,'type' => 'days' , 'message' => 'no data' , 'status' => 0 ] , 200);
        } else {
            // user not found || not active
            return response()->json(['status' => 0 , 'message' => 'failed' , 'user_state' => 'not active'], 404);
        }
    }
    public function all()
    {
        $user = Auth::user();
        $id = $user->id;
        if ($user->state == 1) {
            // last row inserted based on date 
            $last_temp = user_temp::where("user_id" , $id)->latest()->first();
            if (!is_null($last_temp)) {
                $last_temp = $last_temp->created_at->toDateTimeString();
                $sub_Day  =  Carbon::create($last_temp)->subDay()->format("Y-m-d H:i:s");
                $sub_hour  =  Carbon::create($last_temp)->subHour()->format("Y-m-d H:i:s");
                $sub_minute  =  Carbon::create($last_temp)->subMinute()->format("Y-m-d H:i:s");
                $lastDay = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_Day, $last_temp])->orderBy("created_at", 'desc')->get();
                $lastHour = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_hour, $last_temp])->orderBy("created_at", 'desc')->get();
                $lastMinute = user_temp::where("user_id" , $id)->whereBetween("created_at", [$sub_minute, $last_temp])->orderBy("created_at", 'desc')->get();
                $last_sec = user_temp::where('user_id', $id)->orderBy("created_at", 'desc')->first();
                $arr = [
                    "last" =>   $last_sec,
                    "day" =>    $lastDay,
                    "hour" =>    $lastHour,
                    "minute" =>  $lastMinute,
                    "info" => [
                        "day" => [
                            "min" => collect($lastDay)->min("temp"),
                            "max" => collect($lastDay)->max("temp")
                        ],
                        "hour" => [
                            "min" => collect($lastHour)->min("temp"),
                            "max" => collect($lastHour)->max("temp")
                        ],
                        "minute" => [
                            "min" => collect($lastMinute)->min("temp"),
                            "max" => collect($lastMinute)->max("temp")
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
}
