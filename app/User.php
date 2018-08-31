<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $guarded = [];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
