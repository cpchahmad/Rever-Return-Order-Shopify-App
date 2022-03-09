<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_designs', function (Blueprint $table) {
            $table->id();
            $table->string('portal_theme')->nullable();
            $table->string('input_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('input_text')->nullable();
            $table->string('input_back')->nullable();
            $table->string('button_color')->nullable();
            $table->string('button_text')->nullable();
            $table->string('dark_theme')->nullable();
            $table->string('margin')->nullable();
            $table->integer('shop_id')->unsigned();
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
        Schema::dropIfExists('portal_designs');
    }
}
