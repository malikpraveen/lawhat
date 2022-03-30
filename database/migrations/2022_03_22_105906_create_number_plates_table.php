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
            $table->text('logo');
            $table->string('logo_name');
            $table->string('plate_number_en');
            $table->string('plate_number_ar');
            $table->string('plate_alphabets_en');
            $table->string('plate_alphabets_ar');
            $table->float('price');
            $table->string('price_type');
            $table->string('calling_country_code');
            $table->string('calling_number');
            $table->enum('calling_number_type',['registered_number','new_number']);
            $table->string('whatsapp_country_code');
            $table->string('whatsapp_number')->nullable();
            $table->enum('whatsapp_number_type',['registered_number','new_number']);
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
