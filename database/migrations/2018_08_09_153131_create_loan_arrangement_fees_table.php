<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanArrangementFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_arrangement_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_arrangement_fee');
            $table->integer('number_arrangement_fee');
            $table->string('type_arrangement_fee');
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
        Schema::dropIfExists('loan_arrangement_fees');
    }
}
