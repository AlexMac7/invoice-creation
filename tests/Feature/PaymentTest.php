<?php

namespace Tests\Feature;

use App\Customer;
use App\Invoice;
use App\OrderItem;
use App\Payment;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_payments()
    {
        $product = factory(Product::class)->create([
            'price' => 350,
            'name' => 'Sycle Classic',
        ]);
        $customer = factory(Customer::class)->create([
            'name' => 'Test Customer',
        ]);
        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
        ]);
        $orderItem = factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'product_name' => 'Old Name',
            'quantity' => 1,
            'price' => 200,
            'tax' => 10,
        ]);
        $data = [
            'payment_type' => [
                0 => 'credit',
            ],
            'amount' => [
                0 => 20,
            ],
            'invoice_id' => $invoice->id,
        ];

        $response = $this->post("/payments", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('payments', [ //todo
            'id' => $orderItem->id,
            'product_name' => 'New Name',
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'price' => 400,
            'quantity' => 2,
            'tax' => 5,
        ]);
    }

    /** @test */
    public function can_update_payment()
    {
        $product = factory(Product::class)->create([
            'price' => 350,
            'name' => 'Sycle Classic',
        ]);
        $customer = factory(Customer::class)->create([
            'name' => 'Test Customer',
        ]);
        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
        ]);
        $orderItem = factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'product_name' => 'Old Name',
            'quantity' => 1,
            'price' => 200,
            'tax' => 10,
        ]);
        $payment = factory(Payment::class)->create([
            'invoice_id' => $invoice->id,
            'amount' => 1.5,
            'type' => 'e-transfer',
        ]);
        $data = [
            'amount' => 2.1,
            'type' => 'cash',
        ];

        $response = $this->patch("/payments/$payment->id", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'invoice_id' => $invoice->id,
            'amount' => 210,
            'type' => 'cash',
        ]);
    }
}
