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
        $orderItemOne = factory(OrderItem::class)->create([
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'product_name' => 'Old Name',
            'quantity' => 1,
            'price' => 200,
            'tax' => 10,
        ]);
        $data = [
            'product_name' => 'New Name',
            'quantity' => 2,
            'price' => 400,
            'tax' => 5,
        ];

        $response = $this->patch("/order-items/$orderItem->id", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('order_items', [
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
    public function can_update_order_item()
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
            'product_name' => 'New Name',
            'quantity' => 2,
            'price' => 400,
            'tax' => 5,
        ];

        $response = $this->patch("/order-items/$orderItem->id", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('order_items', [
            'id' => $orderItem->id,
            'product_name' => 'New Name',
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'price' => 400,
            'quantity' => 2,
            'tax' => 5,
        ]);
    }
}
