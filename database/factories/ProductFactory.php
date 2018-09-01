<?php

use App\Invoice;
use App\Product;

$factory->define(Product::class, function () {
    return [
        'invoice_id' => function () {
            return factory(Invoice::class)->create()->id;
        },
        'price' => 1900,
        'name' => 'Sycle Classic',
    ];
});
