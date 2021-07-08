<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParturitionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parturition_services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('service_number')->unique();
            $table->dateTime('registration_time');
            $table->uuid('patient_id');
            $table->uuid('medic_id');
            $table->string('phone')->nullable();
            $table->string('payment_method')->default('cash');
            $table->double('service_fee', 15, 2);
            $table->double('discount', 15, 2);
            $table->double('total_fee', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parturition_services');
    }
}
