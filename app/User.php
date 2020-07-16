<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\bpm;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    const VERFIED_USER = '1';
    const UNVERFIED_USER = '0';
    public static function generateVerifiactionCode()
    {
        return str_random(40);
    }
    public function isaVerified()
    {
        return $this->state == User::VERFIED_USER;
    }
    public function lastBpm($id){
        return bpm::where('user_id', $id)->orderBy("created_at", 'desc')->first();
    }
    public function lastBpmMinute($id){
        $last_bpm = bpm::where('user_id', $id)->orderBy("created_at", 'desc')->first();
        if (!is_null($last_bpm)) {
            $last_bpm = $last_bpm->created_at->toDateTimeString();
            $last_bpm = bpm::latest()->first()->created_at->toDateTimeString();
            $sub_minute  =  Carbon::create($last_bpm)->subMinute()->format("Y-m-d H:i:s");
            $ele = bpm::whereBetween("created_at", [$sub_minute, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
            return $ele;
        }
    }
    public function lastBpmHour($id){
        $last_bpm = bpm::where('user_id', $id)->orderBy("created_at", 'desc')->first();
        if (!is_null($last_bpm)) {
            $last_bpm = $last_bpm->created_at->toDateTimeString();
            $last_bpm = bpm::latest()->first()->created_at->toDateTimeString();
            $sub_minute  =  Carbon::create($last_bpm)->subHour()->format("Y-m-d H:i:s");
            $ele = bpm::whereBetween("created_at", [$sub_minute, $last_bpm])->orderBy("created_at", 'desc')->avg('bpm');
            return $ele;
        }
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'heart_audio', 'doctor_call' ,'provider', 'provider_id' , 'avatar' ,'provider' , 'provider_id' , ''
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'bpms'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function bpms()
    {
        return $this->hasMany("App\bpm");
    }
    public function temps()
    {
        return $this->hasMany("App\user_temp");
    }
    public function active()
    {
        if ($this->state == 1) {
            return true;
        }
        return false;
    }
    public function settings()
    {
        return $this->hasOne("App\settings");
    }
    public function doctors()
    {
        return $this->hasMany("App\user_doctors");
    }
    public function families()
    {
        return $this->hasMany('App\family', 'first');
    }
    public function inFamily($id)
    {
        if (count($this->families->where('second', $id)) == 1) {
            return true;
        }
        return false;
    }
    public function FamilyMember($id)
    {
        return $this->families->where('second', $id)->first();
    }
}
