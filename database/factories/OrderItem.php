<?php

use App\Invoice;
use App\OrderItem;
use App\Product;

$factory->define(OrderItem::class, function () {
    return [
        'product_name' => 'Sycle Classic',
        'invoice_id' => function () {
            return factory(Invoice::class)->create()->id;
        },
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'price' => 1900,
        'tax' => 10,
        'quantity' => 1,
    ];
});
