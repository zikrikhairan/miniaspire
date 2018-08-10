<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanInterestRateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_interest_rates')->insert([
            'number_interest_rate' => 1,
            'type_interest_rate' => '%'
        ]);
        
        DB::table('loan_interest_rates')->insert([
            'number_interest_rate' => 2,
            'type_interest_rate' => '%'
        ]);
        
        DB::table('loan_interest_rates')->insert([
            'number_interest_rate' => 3,
            'type_interest_rate' => '%'
        ]);
        
        DB::table('loan_interest_rates')->insert([
            'number_interest_rate' => 4,
            'type_interest_rate' => '%'
        ]);
        
        DB::table('loan_interest_rates')->insert([
            'number_interest_rate' => 5,
            'type_interest_rate' => '%'
        ]);
    }
}
