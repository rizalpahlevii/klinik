<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('receipt_code')->unique();
            $table->date('receipt_date');
            $table->string('buyer_type');
            $table->string('buyer_name');
            $table->double('sub_total', 15, 2);
            $table->double('tax', 15, 2);
            $table->double('discount', 15, 2);
            $table->double('grand_total', 15, 2);
            $table->uuid('doctor_id')->nullable();
            $table->enum('payment_method', ['cash', 'debit']);
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
        Schema::dropIfExists('sales');
    }
}
