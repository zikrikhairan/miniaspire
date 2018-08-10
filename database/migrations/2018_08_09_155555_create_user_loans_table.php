<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_loans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('loan_duration_id');
            $table->unsignedInteger('loan_repayment_frequency_id');
            $table->unsignedInteger('loan_interest_rate_id');
            $table->unsignedInteger('user_id');
            $table->decimal('loan', 20, 2);
            $table->decimal('amount', 20, 2);
            $table->timestamps();

            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('loan_duration_id')->references('id')->on('loan_durations');
            $table->foreign('loan_repayment_frequency_id')->references('id')->on('loan_repayment_frequencies');
            $table->foreign('loan_interest_rate_id')->references('id')->on('loan_interest_rates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_loans');
    }
}
