<?php

use App\Customer;
use App\Invoice;
use App\OrderItem;
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
        factory(Invoice::class)->create([
            'customer_id' => $customer->id,
        ]);
        $product = factory(Product::class)->create([
            'invoice_id' => $invoice->id,
        ]);
        factory(OrderItem::class)->create([
            'product_name' => $product->name,
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'quantity' => 1,
            'tax' => 10,
        ]);
        factory(Payment::class)->create([
            'invoice_id' => $invoice->id,
        ]);
    }
}
