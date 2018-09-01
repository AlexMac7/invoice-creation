<?php

use App\Customer;
use App\Invoice;

$factory->define(Invoice::class, function () {
    return [
        'invoice_number' => 10,
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
        'total' => 1000,
        'note' => 'Test note',
        'invoice_date' => now()->toDateString(),
        'due_date' => now()->addDays(14)->toDateString(),
    ];
});
