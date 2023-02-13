<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->int('booking_box_id');
            $table->string('booking_box_key');
            $table->string('booking_location_id');
            $table->string('booking_parcel_no');
            $table->string('booking_receiver_mobile_no')->nullable();
            $table->timestamp('customer_no_set_at')->nullable();
            $table->integer('booking_parcel_company_id');
            $table->string('booking_booked_by');
            $table->timestamp('booking_booked_at');
            $table->string('booking_receiver_otp', 50)->nullable();
            $table->string('booking_company_otp', 50)->nullable();
            $table->timestamp('booking_collected_at')->nullable();
            $table->text('booking_barcode_url')->nullable();
            $table->string('booking_collected_by')->nullable();
            $table->string('booking_assigned_person_to_return')->nullable();
            $table->boolean('booking_is_expired')->default(0);
            $table->boolean('is_max_pickup_time_passed')->default(0);
            $table->boolean('booking_is_returned')->default(0);
            $table->string('customer_sms_key')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
