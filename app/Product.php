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
        'price' => 'integer',
        'name' => 'string',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->formatMoney($this->price);
    }
}
