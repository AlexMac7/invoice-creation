<?php

namespace Tests\Feature;

use App\Customer;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_invoice_paid_in_full()
    {
        $customer = factory(Customer::class)->create([
            'name' => 'Test Customer',
        ]);
        $product = factory(Product::class)->create([
            'invoice_id' => null,
            'price' => 350,
            'name' => 'Sycle Classic',
        ]);

//        first part: customer name, their address, invoice date, invoice number, due date and note
//        second part: new purchase line items by selecting a product, entering the quantity, price and tax
//        third part: add new payment line items by selecting the payment type and entering the amount
        $data = [
            //first part
            'customer_name' => $customer->name, //todo, should come in as id from a drop down
            'customer_address' => $customer->address,
            'invoice_date' => '2018-09-01',
            'invoice_number' => 13,
            'due_date' => '2018-09-30',
            'note' => 'Great customer!',
//            //second part
            'product_name' => $product->name,
            'quantity' => 2,
            'price' => 350,
            'tax' => 10,
//            //third part
            'payment_type' => 'credit',
            'amount' => 770,
        ];

        $response = $this->post('/invoices', $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('invoices', [
            'invoice_number' => 13,
            'customer_id' => $customer->id,
            'total' => 770,
            'status' => 'paid_in_full',
            'note' => 'Great customer!',
            'is_paid' => true,
            'invoice_date' => '2018-09-01',
            'due_date' => '2018-09-30',
            'paid_at' => '2018-09-01',
        ]);
    }
}
