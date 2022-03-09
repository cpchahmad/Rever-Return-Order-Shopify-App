<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('order_name');
            $table->text('email');
            $table->text('order_id');
            $table->longText('order_json')->nullable();
            $table->integer('shop_id')->unsigned();
            $table->longText('products_json')->nullable();
            $table->text('line_images')->nullable();
            $table->string('prefix')->default('US');
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
        Schema::dropIfExists('orders');
    }
}
