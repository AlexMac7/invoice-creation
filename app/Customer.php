<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'email' => 'string',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
