<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->string('box_location_id');
            $table->string('box_key')->unique();
            $table->string('box_no');
            $table->string('box_size');
            $table->boolean('box_is_online')->default(1);
            $table->timestamp('box_is_online_at')->nullable();
            $table->timestamp('box_is_offline_at')->nullable();
            $table->integer('box_counter')->default(0);
            $table->boolean('box_is_enable')->default(1);
            $table->boolean('box_is_in_maintenance')->default(0);
            $table->boolean('box_is_booked')->default(0);
            $table->boolean('box_is_closed')->default(1);
            $table->string('box_booking_id')->nullable();
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
        Schema::dropIfExists('boxes');
    }
}
