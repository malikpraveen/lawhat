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
            $table->string('user_name');
            $table->string('email')->nullable();
            $table->string('country_code');
            $table->string('mobile_number')->unique();
            $table->string('profile_pic')->nullable();
            $table->string('device_token',1000)->nullable();
            $table->enum('device_type', ['android', 'ios','web']);
            $table->enum('is_otp_verified',['yes','no'])->default('no');
            $table->enum('status',['active','inactive','trashed']);
            $table->rememberToken();
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
