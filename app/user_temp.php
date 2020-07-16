<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_temp extends Model
{
    public $fillable = [
        "user_id",
        "temp"
    ];
    public $hidden = ['updated_at' , 'id' , 'user_id'];
}
