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
        factory(Customer::class)->create([
            'name' => 'Professional Hearing Services',
            'address' => 'St. Joseph, Mi',
        ]);
        factory(Product::class)->create([
            'price' => 1000,
            'name' => 'Sycle Classic',
        ]);
        factory(Product::class)->create([
            'price' => 2000,
            'name' => 'Sycle Pro',
        ]);
        factory(Product::class)->create([
            'price' => 3000,
            'name' => 'Secret Product',
        ]);
    }
}
