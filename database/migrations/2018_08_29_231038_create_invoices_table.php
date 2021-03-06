<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_number')->unique()->unsigned()->index();
            $table->integer('customer_id')->unsigned()->index();
            $table->integer('total');
            $table->integer('subtotal');
            $table->integer('tax')->unsigned();
            $table->enum('status', ['payment_due', 'paid_in_full'])->default('payment_due');
            $table->boolean('is_paid')->default(false);
            $table->string('note')->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('invoices', function ($table) {
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
