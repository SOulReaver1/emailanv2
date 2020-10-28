<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $fillable = ['name'];

    public function files(){
        return $this->belongsToMany('App\File');
    }

}
