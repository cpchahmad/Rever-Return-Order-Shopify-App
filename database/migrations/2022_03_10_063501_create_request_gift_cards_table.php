<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestGiftCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_gift_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('giftcard_id');
            $table->unsignedBigInteger('request_id');
            $table->float('amount');
            $table->string('code');
            $table->string('giftcard_json');
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
        Schema::dropIfExists('request_gift_cards');
    }
}
