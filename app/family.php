<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class family extends Model
{
    protected $table = 'families';
    public $fillable = [
        "first",
        "second",
        "type"
    ];
    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('first', $this->getAttribute('first'))
            ->where('second', $this->getAttribute('second'));
    }
    public function user(){
        return $this->belongsTo('App\User' , 'second');
    }
}
