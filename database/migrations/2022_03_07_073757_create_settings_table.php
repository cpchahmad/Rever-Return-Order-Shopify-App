<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('logo')->nullable();
            $table->text('sender_email')->nullable();
            $table->text('sender_name')->nullable();
            $table->integer('rq_customer')->default(1);
            $table->integer('rq_admin')->default(1);
            $table->integer('ap_customer_rejected')->default(1);
            $table->integer('ap_customer_approved')->default(1);
            $table->integer('rc_customer_product')->default(1);
            $table->integer('rf_customer_product')->default(1);

            $table->longText('rq_customer_template')->nullable();
            $table->longText('rq_admin_template')->nullable();
            $table->longText('ap_approval_template')->nullable();
            $table->longText('ap_reject_template')->nullable();
            $table->longText('rc_received_template')->nullable();
            $table->longText('rf_product_template')->nullable();
            $table->integer('shop_id')->unsigned();
            $table->longText('rq_customer_subject')->nullable();
            $table->longText('rq_admin_subject')->nullable();
            $table->longText('ap_approval_subject')->nullable();
            $table->longText('ap_reject_subject')->nullable();
            $table->longText('rc_received_subject')->nullable();
            $table->longText('rf_product_subject')->nullable();
            $table->string('exchange_text')->nullable();
            $table->string('sku_option')->nullable();
            $table->string('vendor_option')->nullable();
            $table->string('file_upload')->nullable();
            $table->string('upload_title')->nullable();
            $table->string('upload_message')->nullable();
            $table->longText('confirmation_header')->nullable();
            $table->longText('return_address')->nullable();
            $table->longText('seller_instruction')->nullable();
            $table->longText('block_products')->nullable();
            $table->longText('advance_css')->nullable();
            $table->longText('block_customers')->nullable();
            $table->string('sender_username')->nullable();
            $table->string('sender_password')->nullable();
            $table->text('label_subject')->nullable();
            $table->longText('label_message')->nullable();
            $table->boolean('auto_approval')->default(false);
            $table->text('background')->nullable();
            $table->boolean('request_email')->default(true);
            $table->boolean('deny_email')->default(true);
            $table->boolean('approve_email')->default(true);
            $table->boolean('received_email')->default(true);
            $table->boolean('finished_email')->default(true);
            $table->boolean('display_block_product')->default(true);
            $table->text('export_subject')->nullable();
            $table->longText('export_body')->nullable();
            $table->text('package_reminder_subject')->nullable();
            $table->longText('package_reminder_body')->nullable();
            $table->integer('reminder_after')->default(10);
            $table->text('label_expired_subject')->nullable();
            $table->text('label_expired_body')->nullable();
            $table->string('receiver_email')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
