<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoanArrangementFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_loan_arrangement_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_loan_id');
            $table->unsignedInteger('loan_arrangement_fee_id');
            $table->timestamps();
            $table->foreign('user_loan_id')->references('id')->on('user_loans');
            $table->foreign('loan_arrangement_fee_id')->references('id')->on('loan_arrangement_fees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_loan_arrangement_fees');
    }
}
