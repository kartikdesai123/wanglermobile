<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_id')->nullable();
            $table->string('product_name')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->decimal('rate',10,2)->nullable();
            $table->decimal('amout',10,2)->nullable();
            $table->decimal('tax',10,2)->nullable();
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
        Schema::dropIfExists('invoice_product');
    }
}
