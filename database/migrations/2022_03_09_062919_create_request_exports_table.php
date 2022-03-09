<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_exports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('send_to');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('file');
            $table->unsignedBigInteger('shop_id');
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
        Schema::dropIfExists('request_exports');
    }
}
