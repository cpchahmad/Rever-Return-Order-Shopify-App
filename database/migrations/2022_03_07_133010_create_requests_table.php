<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->nullable();
            $table->integer('shop_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->longText('payment_id');
            $table->longText('product')->nullable();
            $table->longText('addition_information')->nullable();
            $table->longText('product_prices');
            $table->string('request_amount');
            $table->string('return_product_image')->nullable();
            $table->string('qr_code')->nullable();
            $table->longText('request_pdf')->nullable();
            $table->string('return_payment_method')->nullable();
            $table->text('custom_shipping_address')->nullable();
            $table->text('items_json')->nullable();
            $table->boolean('store_credited')->default(false);
            $table->boolean('refunded')->default(false);
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
        Schema::dropIfExists('requests');
    }
}
