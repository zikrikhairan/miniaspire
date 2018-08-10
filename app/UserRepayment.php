<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRepayment extends Model
{
    protected $fillable = [
        'id',
        'user_loan_id',
        'number_order',
        'repayment',
        'limit_start_date',
        'limit_end_date',
        'is_paid'
    ];
}
