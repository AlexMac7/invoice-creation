<?php

use App\Invoice;
use App\Product;

$factory->define(Product::class, function () {
    return [
        'price' => 1900,
        'name' => 'Sycle Classic',
    ];
});
