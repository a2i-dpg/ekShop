<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_location_id');
            $table->string('log_box_key')->nullable();
            $table->string('log_event_category')->nullable();
            $table->string('log_event_subcategory')->nullable();
            $table->text('log_event_description')->nullable();
            $table->longText('log_details');
            $table->boolean('log_is_synced')->default(0);
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
        Schema::dropIfExists('event_logs');
    }
}
