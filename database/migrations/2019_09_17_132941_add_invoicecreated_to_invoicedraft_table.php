<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoicecreatedToInvoicedraftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoicedraft', function (Blueprint $table) {
            //
             $table->enum('invoicecreated', ['No','Yes'])->after('note')->default('No');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoicedraft', function (Blueprint $table) {
            //
        });
    }
}
