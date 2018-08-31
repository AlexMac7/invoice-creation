<?php

use App\Invoice;
use App\Product;

$factory->define(Product::class, function () {
    return [
        'invoice_id' => function () {
            return factory(Invoice::class)->create()->id;
        },
        'quantity' => 1,
        'price' => 1900,
        'tax' => 100,
        'name' => 'Sycle Classic',
    ];
});
