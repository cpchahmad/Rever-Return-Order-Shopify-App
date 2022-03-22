<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('kind')->nullable();
            $table->string('gateway')->nullable();
            $table->string('amount')->nullable();
            $table->string('maximum_refundable')->nullable();
            $table->unsignedInteger('request_id');
            $table->string('status')->default('calculated');
            $table->longText('refunded_json')->nullable();
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
        Schema::dropIfExists('request_refunds');
    }
}
