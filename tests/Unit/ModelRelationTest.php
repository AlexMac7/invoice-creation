<?php

namespace Tests\Unit;

use App\Customer;
use App\Invoice;
use App\OrderItem;
use App\Payment;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function models_have_proper_relations()
    {
        $customer = factory(Customer::class)->create();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
        ]);
        $orderItem = factory(OrderItem::class)->create([
            'product_id' => $product->name,
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
        ]);
        $payment = factory(Payment::class)->create([
            'invoice_id' => $invoice->id,
        ]);

        $this->assertEquals($customer->name, $invoice->customer->name);
        $this->assertEquals($invoice->invoice_number, $customer->invoices()->first()->invoice_number);
        $this->assertEquals($invoice->invoice_number, $payment->invoice->invoice_number);
        $this->assertEquals($payment->type, $invoice->payments()->first()->type);
        $this->assertEquals($product->name, $orderItem->product->name);
        $this->assertEquals($invoice->id, $orderItem->invoice->id);
        $this->assertEquals($orderItem->id, $product->orderItems()->first()->id);
    }
}