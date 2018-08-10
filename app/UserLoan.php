<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLoan extends Model
{
    //

    public function loan_durations()
    {
        return $this->belongsTo('App\LoanDuration', 'loan_duration_id','id');
    }

    public function loan_repayment_frequencies()
    {
        return $this->belongsTo('App\LoanRepaymentFrequency', 'loan_repayment_frequency_id','id');
    }

    public function loan_interest_rates()
    {
        return $this->belongsTo('App\LoanInterestRate', 'loan_interest_rate_id','id');
    }
    
    public function user_loan_arrangement_fees()
    {
        return $this->belongsToMany('App\LoanArrangementFee', 'user_loan_arrangement_fees','user_loan_id', 'loan_arrangement_fee_id');
    }

    public function user_repayments()
    {
        return $this->hasMany('App\UserRepayment', 'user_loan_id','id');
    }
}
