<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoiceId')->nullable();
            $table->bigInteger('customerId')->nullable();
            $table->string('customeremail')->nullable();
            $table->string('billingaddress')->nullable();
            $table->date('invoice_date')->format('Y-m-d');
            $table->date('due_date')->format('Y-m-d');
            $table->enum('status', ['Payment', 'Invoice']);
            $table->enum('type', ['Open','Paid', 'Closed', 'Overdue']);
            $table->text('message_on_invoice')->nullable();
            $table->text('message_on_statement')->nullable();
            $table->decimal('total',10,2)->nullable();
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('balance',10,2)->nullable();
            $table->decimal('taxable_subtotal',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
