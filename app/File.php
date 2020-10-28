<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = ['path', 'name', 'size', 'type'];

    public function bases(){
        return $this->belongsToMany('App\Base');
    }
}
