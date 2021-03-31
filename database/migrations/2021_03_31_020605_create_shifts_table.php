<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->string('previous_cashier_name');
            $table->decimal('initial_cash', 15, 2)->default(0);
            $table->decimal('total_sales', 15, 2)->default(0);
            $table->decimal('cash_now')->default(0);
            $table->timestamp('start_shift');
            $table->timestamp('end_shift')->nullable();
            $table->timestamp('previous_end_shift')->nullable();
            $table->enum('status', ['active', 'pause', 'ended']);
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
        Schema::dropIfExists('shifts');
    }
}
