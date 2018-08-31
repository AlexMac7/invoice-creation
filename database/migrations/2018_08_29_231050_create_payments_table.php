<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->enum('type', ['cash', 'credit', 'debit', 'e_transfer']);
            $table->timestamps();
        });

        Schema::table('payments', function ($table) {
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
        Schema::dropIfExists('payments');
    }
}
