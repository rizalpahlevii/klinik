<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('receipt_code')->unique();
            $table->date('receipt_date');
            $table->string('receipt_photo_directory')->nullable();
            $table->uuid('supplier_id');
            $table->uuid('salesman_id');
            $table->double('sub_total', 15, 2);
            $table->double('tax', 15, 2);
            $table->double('discount', 15, 2);
            $table->double('grand_total', 15, 2);
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
        Schema::dropIfExists('purchases');
    }
}
