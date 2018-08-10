<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(LoanDurationTableSeeder::class);
        $this->call(LoanRepaymentFrequencyTableSeeder::class);
        $this->call(LoanInterestRateTableSeeder::class);
        $this->call(LoanArrangementFeeTableSeeder::class);
    }
}
