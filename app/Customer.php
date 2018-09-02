<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
