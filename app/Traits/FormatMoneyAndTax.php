<?php

namespace App\Traits;

trait FormatMoneyAndTax
{
    public function getFormattedTaxAttribute()
    {
        return $this->tax . '%';
    }

    public function formatMoney($number)
    {
        return '$' . money_format('%i', $number / 100);
    }
}
