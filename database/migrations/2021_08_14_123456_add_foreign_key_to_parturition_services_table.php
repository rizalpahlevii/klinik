<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToParturitionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parturition_services', function (Blueprint $table) {
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('CASCADE');

            $table->foreign('medic_id')
                ->references('id')
                ->on('medics')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parturition_services', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['medic_id']);
        });
    }
}
