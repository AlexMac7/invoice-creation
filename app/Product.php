<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'invoice_id' => 'integer',
        'price' => 'integer',
        'name' => 'string',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
