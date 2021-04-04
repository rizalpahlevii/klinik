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
            $table->dateTime('start_shift');
            $table->dateTime('end_shift')->nullable();
            $table->double('initial_cash', 15, 2);
            $table->double('shift_sales_total', 15, 2)->nullable();
            $table->double('final_cash', 15, 2)->nullable();
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
