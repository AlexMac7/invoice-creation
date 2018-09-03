<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name')->index();
            $table->integer('product_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->integer('price');
            $table->integer('quantity')->default(1)->unsigned();
            $table->integer('tax')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('order_items', function ($table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
