<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_labels', function (Blueprint $table) {
            $table->id();
            $table->text('label');
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('order_id');
            $table->string('tracking_code');
            $table->float('fees');
            $table->string('carrier');
            $table->string('status')->default('purchased');
            $table->boolean('fees_applied')->default(false);
            $table->date('last_reminder_date')->default(\Carbon\Carbon::today());
            $table->boolean('email_sent')->default(false);
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
        Schema::dropIfExists('request_labels');
    }
}
