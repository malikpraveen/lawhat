<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberPlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_plates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('logo')->nullable();
            $table->string('logo_name')->nullable();
            $table->string('plate_number_en');
            $table->string('plate_number_ar')->nullable();
            $table->string('plate_alphabets_en');
            $table->string('plate_alphabets_ar')->nullable();
            $table->float('price');
            $table->string('price_type');
            $table->string('calling_country_code')->nullable();
            $table->string('calling_number')->nullable();
            $table->enum('calling_number_type',['registered_number','new_number'])->nullable();
            $table->string('whatsapp_country_code')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->enum('whatsapp_number_type',['registered_number','new_number'])->nullable();
            $table->string('email')->nullable();;
            $table->enum('added_by',['0','1'])->comment("0=user,1=admin");
            $table->enum('plate_status',['0','1','2'])->default('1')->comment("0=active,1=pending,2=sold");
            $table->enum('status',['enable','disable','trashed']);
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
        Schema::dropIfExists('number_plates');
    }
}
