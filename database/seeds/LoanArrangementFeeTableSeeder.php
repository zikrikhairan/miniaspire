<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanArrangementFeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_arrangement_fees')->insert([
            'name_arrangement_fee' => 'Administration Charge',
            'number_arrangement_fee' => 10000,
            'type_arrangement_fee' => 'Rupiah',
        ]);
        DB::table('loan_arrangement_fees')->insert([
            'name_arrangement_fee' => 'Print Charge',
            'number_arrangement_fee' => 10000,
            'type_arrangement_fee' => 'Rupiah',
        ]);
    }
}
