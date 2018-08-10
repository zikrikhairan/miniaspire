<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_loan_id');
            $table->integer('number_order');
            $table->decimal('repayment', 20, 2);
            $table->date('limit_start_date');
            $table->date('limit_end_date');
            $table->boolean('is_paid')->default(0);
            $table->timestamps();
            $table->foreign('user_loan_id')->references('id')->on('user_loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_repayments');
    }
}
