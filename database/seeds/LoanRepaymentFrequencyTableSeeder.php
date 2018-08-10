<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanRepaymentFrequencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_repayment_frequencies')->insert([
            'number_repayment_frequency' => 1,
            'type_repayment_frequency' => 'Month'
        ]);
    }
}
