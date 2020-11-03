<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('productId')->nullable();
            $table->string('productname')->nullable();
            $table->string('sku')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('quantityonhand')->nullable();
            $table->date('quantityonhanddate')->nullable();
            $table->string('reorderpoint')->nullable();
            $table->string('inventoryassetaccount')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->string('incomeaccount')->nullable();
            $table->text('purchasinginformation')->nullable();
            $table->decimal('cost',10,2)->nullable();
            $table->string('expenseaccount')->nullable();
            $table->string('vendor')->nullable();
            $table->enum('isactive', ['yes', 'no']);
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
        Schema::dropIfExists('product');
    }
}
