<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('draft_order_id');
            $table->unsignedBigInteger('request_id');
            $table->string('email');
            $table->string('name');
            $table->string('status');
            $table->float('total_price');
            $table->float('subtotal_price');
            $table->float('total_tax')->default(0);
            $table->float('applied_discount')->default(0);
            $table->longText('draft_json');
            $table->timestamps();
            $table->foreign('request_id')->references('id')->on('requests');
            $table->unsignedBigInteger('order_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_exchanges');
    }
}
