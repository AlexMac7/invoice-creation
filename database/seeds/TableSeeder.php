<?php

use App\Customer;
use App\Invoice;
use App\Payment;
use App\Product;
use App\User;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create();
        $customer = factory(Customer::class)->create();
        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
        ]);
        factory(Product::class)->create([
            'invoice_id' => $invoice->id,
        ]);
        factory(Payment::class)->create([
            'invoice_id' => $invoice->id,
        ]);
    }
}
