<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('company_id')->nullable();
            $table->string('location_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('users');
    }
}
