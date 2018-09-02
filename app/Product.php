<?php

namespace App;

use App\Traits\FormatMoneyAndTax;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, FormatMoneyAndTax;

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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->formatMoney($this->price);
    }
}
