<?php

namespace App\Http\Controllers;

use App\bpm;
use App\family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\userProfile as usprof;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\Table;

class userController extends Controller
{
    public function api_route(){
        return view('user.api');
    }
    // [[[[[[[[[[[[[[[[[[[ user ]]]]]]]]]]]]]]]]]]]
    public function userprofile($id)
    {
        if(Auth::user()->id == $id){
            return redirect(route('user_profile'));
        }
        $user = User::findOrFail($id);
        $info = [
            'type' => ''
        ];
        if(Auth::user()->inFamily($id)){
            $info = Auth::user()->FamilyMember($id);
            $data = [
                'bpm' => $user->bpms->last()->bpm,
                'temp' => $user->temps->last()->temp
            ];
            return view('user.friend', compact('user' , 'info' , 'data'));
        }
        return view('user.friend', compact('user' , 'info'));
    }
    public function adduser(Request $req)
    {
        $this->validate($req, [
            'second' => 'required',
            'type'   => 'required|in:son,father,wife'
        ]);
        $first = Auth::user();
        $second = User::find($req->second);
        $tip = "";
        if (!is_null($second)) {
            if (!$first->inFamily($second->id)) {
                $member = new family();
                $member->first = $first->id;
                $member->second = $second->id;
                $member->type = $req->type;
                $member->save();
                return redirect()->back();
            }
        }
        return redirect()->back();
    }
    public function removeuser(Request $req){
        $this->validate($req, [
            'second' => 'required',
        ]);
        $first = Auth::user();
        $second = User::find($req->second);
        if (!is_null($second)) {
            if ($first->inFamily($second->id)) {
                $first->FamilyMember($second->id)->delete();
                return redirect()->back();
            }
        }
        return redirect()->back();
    }
    public function search(Request $req)
    {
        $user = Auth::user();
        $name = $req->name;
        if ($name != "") {
            $result = User::select(['name', 'id'])->where('name', 'like', "%" . $name . "%")
                // ->get(['name' , 'id' , 'email'])
                ->paginate(10)
                ->withPath('/search?name=' . $name);
            return view('user.search', compact('result', 'name', 'user'));
        } else {
            return redirect(route('user_profile'));
        }
    }
    public function family(){
        $family = Auth::user()->families;
        return view('user.family' , compact('family'));
    }
    // [[[[[[[[[[[[[ auth user ]]]]]]]]]]]]]
    public function profile()
    {
        $user = Auth::user();
        $date = Carbon::today()->toDateString();
        return view("user.profile", compact('user' , 'date'));
    }

    // [[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[not completed]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]
    public function updateProfile(Request $data)
    {
        $this->validate($data , [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'numeric', 'min:1' , 'max:100'],
            'geneder' => ['required', 'string' , 'in:male,female'],
            'password' => ['nullable', 'string', 'min:4' , 'confirmed'],
            'phone' => "numeric|min:6",
            'start_sleep' => "nullable|date_format:H:i",
            'end_sleep' => "nullable|date_format:H:i"  
        ]);
        
        $user = Auth::user();
        if(!is_null($data->name)){
            $user->name = $data->name;
        }
        if(!is_null($data->phone)){
            $user->phone = $data->phone;
        }
        if(!is_null($data->age)){
            $user->age = $data->age;
        }
        if(!is_null($data->geneder)){
            $user->geneder = $data->geneder;
        }
        if(!is_null($data->password)){
            $user->password = Hash::make($data->password);
        }
        if(!is_null($data->start_sleep)){
            $user->start_sleep = $data->start_sleep;
        }
        if(!is_null($data->end_sleep)){
            $user->end_sleep = $data->end_sleep;
        }
        $user->save();
        return redirect()->back();
    }
    // [[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]
    public function heartModel()
    {
        $user = Auth::user();
        $token =  $user->api_token;
        $doctors = $user->doctors;
        if (!is_null($user) && $user->state == 1) {
            return view('user.heart', compact('token', 'user', 'doctors'));
        } else {
            return redirect("/");
        }
    }
    public function data()
    {
        $user = Auth::user();
        if (!is_null($user) && $user->state == 1) {
            $last_bpm = bpm::where("user_id" , $user->id)->latest()->first();
            if (!is_null($last_bpm)) {
                $last_bpm = $last_bpm->created_at->toDateTimeString();
                $sub_Day  =  Carbon::create($last_bpm)->subDay()->format("Y-m-d H:i:s");
                $sub_hour  =  Carbon::create($last_bpm)->subHour()->format("Y-m-d H:i:s");
                $sub_minute  =  Carbon::create($last_bpm)->subMinute()->format("Y-m-d H:i:s");

                $userBpms =  bpm::where("user_id", $user->id)->orderBy("created_at", 'desc');
                $lastDay = $userBpms->whereBetween("created_at", [$sub_Day, $last_bpm])->get();
                $lastHour = $userBpms->whereBetween("created_at", [$sub_hour, $last_bpm])->get();
                $lastMinute = $userBpms->whereBetween("created_at", [$sub_minute, $last_bpm])->get();
                $last_sec = $userBpms->first();

                $data = [
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
                // user with data and active
                return view('user.data', compact('user', 'data'));
            }
            // user without data and active
            return view('user.data', compact('user'));
        } else {
            return redirect("/");
        }
    }
}
