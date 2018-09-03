<?php

namespace Tests\Feature;

use App\Customer;
use App\Invoice;
use App\Product;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_invoice_for_existing_customer()
    {
        $customer = factory(Customer::class)->create([
            'name' => 'Test Customer',
        ]);
        $product1 = factory(Product::class)->create([
            'price' => 350,
            'name' => 'Sycle Classic',
        ]);
        $product2 = factory(Product::class)->create([
            'price' => 400,
            'name' => 'Sycle Pro',
        ]);
        $product3 = factory(Product::class)->create([
            'price' => 500,
            'name' => 'Secret Product',
        ]);

        $data = [
            //first part
            'customer_name' => $customer->name,
            'customer_address' => $customer->address,
            'invoice_date' => '2018-09-01',
            'invoice_number' => 13,
            'due_date' => '2018-09-30',
            'note' => 'Great customer!',
            //second part
            'product_name' => [
                0 => $product1->name,
                1 => $product2->name,
                2 => $product3->name,
            ],
            'quantity' => [
                0 => 2,
                1 => 1,
                2 => 6,
            ],
            'price' => [
                0 => 350,
                1 => 400,
                2 => 600,
            ],
            'tax' => [
                0 => 10,
                1 => 10,
                2 => 10,
            ],
            'product_id' => [
                0 => $product1->id,
                1 => $product2->id,
                2 => $product3->id,
            ],
            //third part
            'payment_type' => [
                0 => 'credit',
                1 => 'cash',
                2 => 'e-transfer',
            ],
            'amount' => [
                0 => 600,
                1 => 510,
                2 => 3960,
            ],
        ];

        $response = $this->post('/invoices', $data);
        $response->assertStatus(302);

        $invoice = Invoice::where('invoice_number', 13)->first();
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'invoice_number' => 13,
            'customer_id' => $customer->id,
            'total' => 5170,
            'subtotal' => 4700,
            'tax' => 10,
            'status' => 'payment_due',
            'note' => 'Great customer!',
            'is_paid' => false,
            'invoice_date' => Carbon::parse('September 1 2018')->toDateString(),
            'due_date' => Carbon::parse('September 30 2018')->toDateString(),
            'paid_at' => null,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_name' => $product1->name,
            'invoice_id' => $invoice->id,
            'product_id' => $product1->id,
            'price' => 350,
            'quantity' => 2,
            'tax' => 10,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_name' => $product2->name,
            'invoice_id' => $invoice->id,
            'product_id' => $product2->id,
            'price' => 400,
            'quantity' => 1,
            'tax' => 10,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_name' => $product3->name,
            'invoice_id' => $invoice->id,
            'product_id' => $product3->id,
            'price' => 600,
            'quantity' => 6,
            'tax' => 10,
        ]);
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 600,
            'type' => 'credit',
        ]);
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 510,
            'type' => 'cash',
        ]);
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 3960,
            'type' => 'e-transfer',
        ]);
    }

    /** @test */
    public function can_create_invoice_for_new_customer()
    {
        $product1 = factory(Product::class)->create([
            'price' => 350,
            'name' => 'Sycle Classic',
        ]);
        $product2 = factory(Product::class)->create([
            'price' => 400,
            'name' => 'Sycle Pro',
        ]);

        $data = [
            //first part
            'customer_name' => 'Test Customer',
            'customer_address' => 'Test Address',
            'invoice_date' => '2018-09-01',
            'invoice_number' => 13,
            'due_date' => '2018-09-30',
            'note' => 'Great customer!',
            //second part
            'product_name' => [
                0 => $product1->name,
                1 => $product2->name,
            ],
            'quantity' => [
                0 => 2,
                1 => 1,
            ],
            'price' => [
                0 => 350,
                1 => 400,
            ],
            'tax' => [
                0 => 10,
                1 => 5,
            ],
            'product_id' => [
                0 => $product1->id,
                1 => $product2->id,
            ],
            //third part
            'payment_type' => [
                0 => 'credit',
                1 => 'cash',
            ],
            'amount' => [
                0 => 600,
                1 => 610,
            ],
        ];

        $response = $this->post('/invoices', $data);
        $response->assertStatus(302);

        $invoice = Invoice::where('invoice_number', 13)->first();
        $customer = Customer::where([
            ['name', 'Test Customer'],
            ['address',  'Test Address'],
        ])->first();
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'invoice_number' => 13,
            'customer_id' => $customer->id,
            'total' => 1210,
            'subtotal' => 1100,
            'tax' => 10,
            'status' => 'paid_in_full',
            'note' => 'Great customer!',
            'is_paid' => true,
            'invoice_date' => Carbon::parse('September 1 2018')->toDateString(),
            'due_date' => Carbon::parse('September 30 2018')->toDateString(),
            'paid_at' => now()->toDateString(),
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_name' => $product1->name,
            'invoice_id' => $invoice->id,
            'product_id' => $product1->id,
            'price' => 350,
            'quantity' => 2,
            'tax' => 10,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_name' => $product2->name,
            'invoice_id' => $invoice->id,
            'product_id' => $product2->id,
            'price' => 400,
            'quantity' => 1,
            'tax' => 10,
        ]);
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 600,
            'type' => 'credit',
        ]);
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 610,
            'type' => 'cash',
        ]);
    }
}
