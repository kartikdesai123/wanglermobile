<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('companyname')->nullable();
            $table->text('displayname')->nullable();
            $table->text('printname')->nullable();
            $table->enum('printcheckas',['yes','no'])->default('no');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('other')->nullable();
            $table->string('website')->nullable();
            $table->enum('issubcustomer',['yes','no'])->default('no');
            $table->string('parentcustomer')->nullable();
            $table->string('billwith')->nullable();
            $table->string('billingaddstreet')->nullable();
            $table->string('billingaddcity')->nullable();
            $table->string('billingaddstate')->nullable();
            $table->string('billingaddzip')->nullable();
            $table->string('billingaddcountry')->nullable();
            $table->string('shippingaddstreet')->nullable();
            $table->string('shippingaddcity')->nullable();
            $table->string('shippingaddstate')->nullable();
            $table->string('shippingaddzip')->nullable();
            $table->string('shippingaddcountry')->nullable();
            $table->text('note')->nullable();
            $table->string('exemptiondetails')->nullable();
            $table->enum('iscustomertaxable',['yes','no'])->default('no');
            $table->string('taxcode')->nullable();
            $table->string('paymentmethode')->nullable();
            $table->string('deliverymethode')->nullable();
            $table->string('terms')->nullable();
            $table->string('openingbalance')->nullable();
            $table->date('openingbalancedate')->nullable();
            $table->string('attachments')->nullable();
            $table->string('customertype')->nullable();
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
        Schema::dropIfExists('customer');
    }
}
