<?php

use App\Invoice;
use App\Payment;

$factory->define(Payment::class, function () {
    return [
        'invoice_id' => function () {
            return factory(Invoice::class)->create()->id;
        },
        'amount' => 2000,
        'type' => 'credit',
    ];
});
