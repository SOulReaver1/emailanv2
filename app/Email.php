<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'base_id', 'email', 'sha256', 'md5', 'tags'
    ];

    protected $casts = [
        'tags' => 'array'
    ];
}
