<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier_shifts', function (Blueprint $table) {
            $table->uuid('id');

            $table->uuid('cashier_id')->comment('user id');
            $table->uuid('previous_shift_id')->nullable();

            $table->dateTime('start_shift');
            $table->dateTime('end_shift')->nullable();
            $table->double('initial_cash', 15, 2);
            $table->double('shift_sales_total', 15, 2)->default(0);
            $table->double('final_cash', 15, 2)->default(0);
            
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
        Schema::dropIfExists('cashier_shifts');
    }
}
