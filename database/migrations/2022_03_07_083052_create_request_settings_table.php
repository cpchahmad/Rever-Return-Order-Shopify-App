<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_settings', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id');
            $table->string('decline_status')->nullable();
            $table->string('decline_month')->nullable();
            $table->string('finish_status')->nullable();
            $table->string('finish_month')->nullable();
            $table->boolean('auto_approval')->default(false);
            $table->text('return_able_text')->nullable();
            $table->string('valid_return_date')->nullable();
            $table->boolean('display_block_product')->default(true);
            $table->text('exchange_product_tags')->nullable();
            $table->text('payment_product_tags')->nullable();
            $table->text('store_product_tags')->nullable();
            $table->boolean('exclude_non_us_order')->default(true);
            $table->text('special_orders')->nullable();
            $table->text('exclude_orders')->nullable();
            $table->text('exchange_orders')->nullable();
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
        Schema::dropIfExists('request_settings');
    }
}
