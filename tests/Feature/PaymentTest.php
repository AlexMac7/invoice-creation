<?php

namespace Tests\Feature;

use App\Customer;
use App\Invoice;
use App\OrderItem;
use App\Payment;
use App\Product;
use Carbon\Carbon;
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
            'invoice_number' => 13,
            'customer_id' => $customer->id,
            'total' => 210,
            'subtotal' => 200,
            'tax' => 10,
            'status' => 'payment_due',
            'note' => 'Great customer!',
            'is_paid' => false,
            'invoice_date' => Carbon::parse('September 1 2018')->toDateString(),
            'due_date' => Carbon::parse('September 30 2018')->toDateString(),
        ]);
        $orderItem = factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'product_name' => 'Old Name',
            'quantity' => 1,
            'price' => 200,
            'tax' => 10,
        ]);
        factory(Payment::class)->create([
            'invoice_id' => $invoice->id,
            'amount' => 110,
            'type' => 'e-transfer',
        ]);
        $data = [
            'payment_type' => [
                0 => 'credit',
            ],
            'amount' => [
                0 => 1,
            ],
            'invoice_id' => $invoice->id,
        ];

        $response = $this->post("/payments", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'paid_in_full',
            'is_paid' => true,
        ]);
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 100,
            'type' => 'credit',
        ]);
    }

    /** @test */
    public function can_update_and_increase_payment()
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
            'total' => 210,
            'subtotal' => 200,
            'tax' => 10,
            'status' => 'payment_due',
            'is_paid' => false,
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
            'amount' => 150,
            'type' => 'e-transfer',
        ]);
        $data = [
            'amount' => 2.1,
            'type' => 'cash',
        ];

        $response = $this->patch("/payments/$payment->id", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'paid_in_full',
            'is_paid' => true,
        ]);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'invoice_id' => $invoice->id,
            'amount' => 210,
            'type' => 'cash',
        ]);
    }

    /** @test */
    public function can_update_and_decrease_payment()
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
            'total' => 210,
            'subtotal' => 200,
            'tax' => 10,
            'status' => 'paid_in_full',
            'is_paid' => true,
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
            'amount' => 210,
            'type' => 'e-transfer',
        ]);
        $data = [
            'amount' => 1,
            'type' => 'debit',
        ];

        $response = $this->patch("/payments/$payment->id", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'payment_due',
            'is_paid' => false,
        ]);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'invoice_id' => $invoice->id,
            'amount' => 100,
            'type' => 'debit',
        ]);
    }
}
