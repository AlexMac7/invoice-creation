<?php

namespace App\Traits;

trait FormatMoney
{
    public function getFormattedTaxAttribute()
    {
        return $this->tax . '%';
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . money_format('%i', $this->price / 100);
    }
}
