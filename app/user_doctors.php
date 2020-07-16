<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_doctors extends Model
{
    public $fillable = ['name' , 'phone' , 'address' , 'info' , 'facebook' , 'user_id'];
}
