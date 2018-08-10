<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanDurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_durations')->insert([
            'number_duration' => 3,
            'type_duration' => 'Month'
        ]);
        
        DB::table('loan_durations')->insert([
            'number_duration' => 6,
            'type_duration' => 'Month'
        ]);
        
        DB::table('loan_durations')->insert([
            'number_duration' => 12,
            'type_duration' => 'Month'
        ]);
        
        DB::table('loan_durations')->insert([
            'number_duration' => 24,
            'type_duration' => 'Month'
        ]);
    }
}
