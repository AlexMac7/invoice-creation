<?php

namespace App;

use App\Traits\FormatMoneyAndTax;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use FormatMoneyAndTax;

    protected $guarded = [];

    protected $casts = [
        'product_name' => 'string',
        'invoice_id' => 'integer',
        'product_id' => 'integer',
        'price' => 'integer',
        'quantity' => 'string',
        'tax' => 'string',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->formatMoney($this->price);
    }
}
