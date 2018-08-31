<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'invoice_id' => 'integer',
        'amount' => 'integer',
        'type' => 'string',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
