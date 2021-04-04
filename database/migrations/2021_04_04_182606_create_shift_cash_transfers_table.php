<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftCashTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_cash_transfers', function (Blueprint $table) {
            $table->id();
            $table->uuid('cashier_id');
            $table->uuid('cashier_shift_id');
            $table->double('total_transfer');
            $table->string('transfer_proof')->nullable();
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
        Schema::dropIfExists('shift_cash_transfers');
    }
}
