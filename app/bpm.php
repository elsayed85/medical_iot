<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class bpm extends Model
{
    protected $table = "bpms";
    public $fillable = [
        "user_id",
        "bpm"
    ];
    public $hidden = ['updated_at' , 'id' , 'user_id'];
    public function user(){
        return $this->belongsTo("App/User");
    }
    // public function getCreatedAtAttribute($value){
    //     return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    // }
}
