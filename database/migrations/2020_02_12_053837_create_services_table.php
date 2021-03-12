<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_number')->unique();
            $table->dateTime('registration_time');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('medic_id');
            $table->string('phone');
            $table->double('service_fee', 15, 2);
            $table->double('discount', 15, 2);
            $table->double('total_fee', 15, 2);
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('services');
    }
}
