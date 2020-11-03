<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicedraftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicedraft', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userid')->nullable();
            $table->string('invoiceid')->nullable();
            $table->integer('productid')->nullable();
            $table->integer('customerid')->nullable();
            $table->integer('quantity')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('invoicedraft');
    }
}
