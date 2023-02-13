<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('sms_location_id');
            $table->string('sms_key');
            $table->string('sms_event_type');
            $table->string('sms_receiver_number');
            $table->string('sms_text');
            $table->integer('counter_retry')->default(0);
            $table->boolean('sms_is_sent')->default(0);
            $table->timestamp('sms_sent_time')->nullable();
            $table->boolean('sms_is_synced')->default(0);
            $table->boolean('is_soft_deleted')->default(0);
            $table->timestamp('soft_deleted_at')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
