<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_products', function (Blueprint $table) {
            $table->id();
            $table->string('line_item_id');
            $table->string('variant_id');
            $table->string('product_name');
            $table->string('product_id');
            $table->string('return_type');
            $table->string('reason');
            $table->string('shop_id');
            $table->string('order_id');
            $table->string('request_id');
            $table->string('product_sku');
            $table->string('product_image');
            $table->string('product_quantity');
            $table->string('return_amount');
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
        Schema::dropIfExists('request_products');
    }
}
