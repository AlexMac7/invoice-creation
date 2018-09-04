<?php

namespace Tests\Feature;

use App\Customer;
use App\Invoice;
use App\OrderItem;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_order_items()
    {
        $productOne = factory(Product::class)->create([
            'price' => 350,
            'name' => 'Sycle Classic',
        ]);
        $productTwo = factory(Product::class)->create([
            'price' => 600,
            'name' => 'Sycle Pro',
        ]);
        $customer = factory(Customer::class)->create([
            'name' => 'Test Customer',
        ]);
        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
            'total' => 550,
            'subtotal' => 500,
            'tax' => 10,
            'status' => 'paid_in_full',
            'is_paid' => true,
        ]);
        $orderItem = factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $productOne->id,
            'product_name' => 'Sycle Classic',
            'quantity' => 1,
            'price' => 500,
            'tax' => 10,
        ]);
        $data = [
            'product_name' => [
                0 => 'New Name',
            ],
            'quantity' => [
                0 => 2,
            ],
            'price' => [
                0 => 2,
            ],
            'tax' => [
                0 => 10,
            ],
            'product_id' => [
                0 => $productTwo->id,
            ],
            'invoice_id' => $invoice->id,
        ];

        $response = $this->post("/order-items", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('invoices', [
            'customer_id' => $customer->id,
            'total' => 990,
            'subtotal' => 900,
            'tax' => 10,
            'status' => 'payment_due',
            'is_paid' => false,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_name' => 'New Name',
            'invoice_id' => $invoice->id,
            'product_id' => $productTwo->id,
            'price' => 200,
            'quantity' => 2,
            'tax' => 10,
        ]);
    }

    /** @test */
    public function can_update_order_item_with_increased_price()
    {
        $productOne = factory(Product::class)->create([
            'price' => 200,
            'name' => 'Sycle Classic',
        ]);
        $productTwo = factory(Product::class)->create([
            'price' => 400,
            'name' => 'Sycle Pro',
        ]);
        $customer = factory(Customer::class)->create([
            'name' => 'Test Customer',
        ]);
        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
            'total' => 770,
            'subtotal' => 700,
            'tax' => 10,
            'status' => 'paid_in_full',
            'is_paid' => true,
        ]);
        $orderItem = factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $productOne->id,
            'product_name' => 'Old Name',
            'quantity' => 1,
            'price' => 200,
            'tax' => 10,
        ]);
        factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $productTwo->id,
            'product_name' => $productTwo->name,
            'quantity' => 1,
            'price' => 500,
            'tax' => 10,
        ]);
        $data = [
            'product_name' => 'New Name',
            'quantity' => 2,
            'price' => 4,
            'tax' => 10,
        ];

        $response = $this->patch("/order-items/$orderItem->id", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('invoices', [
            'customer_id' => $customer->id,
            'total' => 1430,
            'subtotal' => 1300,
            'tax' => 10,
            'status' => 'payment_due',
            'is_paid' => false,
        ]);
        $this->assertDatabaseHas('order_items', [
            'id' => $orderItem->id,
            'product_name' => 'New Name',
            'invoice_id' => $invoice->id,
            'product_id' => $productOne->id,
            'price' => 400,
            'quantity' => 2,
            'tax' => 10,
        ]);
    }

    /** @test */
    public function can_update_order_item_with_decreased_price()
    {
        $productOne = factory(Product::class)->create([
            'price' => 200,
            'name' => 'Sycle Classic',
        ]);
        $productTwo = factory(Product::class)->create([
            'price' => 400,
            'name' => 'Sycle Pro',
        ]);
        $customer = factory(Customer::class)->create([
            'name' => 'Test Customer',
        ]);
        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
            'total' => 770,
            'subtotal' => 700,
            'tax' => 10,
            'status' => 'payment_due',
            'is_paid' => false,
        ]);
        $orderItem = factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $productOne->id,
            'product_name' => 'Old Name',
            'quantity' => 1,
            'price' => 200,
            'tax' => 10,
        ]);
        factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $productTwo->id,
            'product_name' => $productTwo->name,
            'quantity' => 1,
            'price' => 500,
            'tax' => 10,
        ]);
        $data = [
            'product_name' => 'New Name',
            'quantity' => 1,
            'price' => 1,
            'tax' => 10,
        ];

        $response = $this->patch("/order-items/$orderItem->id", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('invoices', [
            'customer_id' => $customer->id,
            'total' => 660,
            'subtotal' => 600,
            'tax' => 10,
            'status' => 'paid_in_full',
            'is_paid' => true,
        ]);
        $this->assertDatabaseHas('order_items', [
            'id' => $orderItem->id,
            'product_name' => 'New Name',
            'invoice_id' => $invoice->id,
            'product_id' => $productOne->id,
            'price' => 100,
            'quantity' => 1,
            'tax' => 10,
        ]);
    }
}
