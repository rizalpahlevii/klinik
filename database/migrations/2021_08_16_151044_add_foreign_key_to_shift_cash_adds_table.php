<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToShiftCashAddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shift_cash_adds', function (Blueprint $table) {
            $table->foreign('cashier_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('cashier_shift_id')
                ->references('id')
                ->on('cashier_shifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shift_cash_adds', function (Blueprint $table) {
            $table->dropForeign(['cashier_id']);
            $table->dropForeign(['cashier_shift_id']);
        });
    }
}
