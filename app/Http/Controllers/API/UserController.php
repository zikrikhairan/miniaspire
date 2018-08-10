<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Carbon\Carbon;

use App\User;
use App\UserLoan;
use App\LoanDuration;
use App\LoanInterestRate;
use App\LoanRepaymentFrequency;
use App\LoanArrangementFee;
use App\UserLoanArrangementFee;
use App\UserRepayment;


class UserController extends Controller
{
    public $successStatus = 200;
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }

    public function details() 
    { 
        $user = Auth::user(); 
        $user = User::find($user->id)->with('user_loans', 'user_loans.user_repayments')->get();
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    public function add_loans() 
    {
        // dd(request()->all());
        $user = Auth::user(); 
        $validator = Validator::make(request()->all(), [ 
            'loan_duration_id' => 'required', 
            'loan_repayment_frequency_id' => 'required', 
            'loan_interest_rate_id' => 'required',
            'loan' => 'required|integer'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $loan_duration = LoanDuration::find(request('loan_duration_id'));
        if(empty($loan_duration)){
            return 'Loan Duration ID Not Found';
        }
        $loan_repayment_frequency = LoanRepaymentFrequency::find(request('loan_repayment_frequency_id'));
        if(empty($loan_repayment_frequency)){
            return 'Loan Repayment Frequency ID Not Found';
        }
        $loan_interest_rate = LoanInterestRate::find(request('loan_interest_rate_id'));
        if(empty($loan_interest_rate)){
            return 'Loan Interest Rate ID Not Found';
        }
        foreach(request('loan_arrangement_fee') as $laf){
            $loan_arrangement_fee = LoanArrangementFee::find($laf);
            if(empty($loan_arrangement_fee)){
                return 'Loan Arrangement Fee ID Not Found';
            }
        }
        if($loan_duration->type_duration == $loan_repayment_frequency->type_repayment_frequency){
            $loan_duration_id = request('loan_duration_id');
            $loan_repayment_frequency_id = request('loan_repayment_frequency_id');
            $loan_interest_rate_id = request('loan_interest_rate_id');
            $loan = request('loan');

            $user_loan_amount = $loan+($loan*$loan_interest_rate->number_interest_rate/100);
            foreach(request('loan_arrangement_fee') as $laf){
                $loan_arrangement_fee = LoanArrangementFee::find($laf);
                $user_loan_amount +=  $loan_arrangement_fee->number_arrangement_fee;
            }
            $user_loan = new UserLoan();
            $user_loan->user_id = $user->id;
            $user_loan->loan_duration_id = $loan_duration_id;
            $user_loan->loan_repayment_frequency_id = $loan_repayment_frequency_id;
            $user_loan->loan_interest_rate_id = $loan_interest_rate_id;
            $user_loan->loan = $loan;
            $user_loan->amount = $user_loan_amount;
            $user_loan->save();
            foreach(request('loan_arrangement_fee') as $laf){
                $user_loan_arrangement_fee = new UserLoanArrangementFee();
                $user_loan_arrangement_fee->user_loan_id = $user_loan->id;
                $user_loan_arrangement_fee->loan_arrangement_fee_id = $laf;
                $user_loan_arrangement_fee->save();
            }
            for($number=1; $number<=$loan_duration->number_duration; $number++){
                $user_repayment = new UserRepayment();
                $user_repayment->user_loan_id = $user_loan->id;
                $user_repayment->number_order = $number;
                $user_repayment->repayment = $user_loan_amount/$loan_duration->number_duration;
                $user_repayment->limit_start_date = Carbon::now()->addMonth($number);
                $user_repayment->limit_end_date = Carbon::now()->addMonth($number+1)->addDays(-1);
                $user_repayment->save();
            }

            $user = User::find($user->id)->with('user_loans', 'user_loans.user_repayments')->get();
            // return $loan_duration->number_duration*$loan_repayment_frequency->number_repayment_frequency;
        }
        else{
            return 'Different Type';
        }
        
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    public function repayment() 
    { 
        // dd(request()->all());
        $user = Auth::user(); 
        $validator = Validator::make(request()->all(), [ 
            'user_loan_id' => 'required', 
            'date' => 'required',
            'paid' => 'required'
        ]);
        $user_loan = UserLoan::find(request('user_loan_id'));
        if(empty($user_loan)){
            return 'User Loan ID Not Found';
        }
        $user_loan_id = request('user_loan_id');
        $date = request('date');
        $paid = request('paid');
        $user_repayment = UserRepayment::where('user_loan_id', $user_loan->id)
            ->where('is_paid', 0)
            ->where('limit_end_date', '<', $date)
            ->get();
        if(!empty($user_repayment)){
            $message = '';
            if(count($user_repayment)>0){
                $message =  'Loan was not paid '.count($user_repayment).' months earlier';
            }
            else{
                $user_repayment = UserRepayment::where('user_loan_id', $user_loan->id)
                    ->where('is_paid', 0)
                    ->where('limit_start_date', '<=', $date)
                    ->where('limit_end_date', '>=', $date)
                    ->first();
                if(!empty($user_repayment)){
                    if(count($user_repayment)>0){
                        // dd($paid);
                        if($paid=='true'){
                            $set_paid = UserRepayment::find($user_repayment->id);
                            $set_paid->is_paid = 1;
                            $set_paid->save();
                            $message =  "This month's loan has been paid";
                        }
                    }
                }
                $user_repayment = UserRepayment::where('user_loan_id', $user_loan->id)
                    ->where('is_paid', 1)
                    ->where('limit_start_date', '>=', $date)
                    ->where('limit_end_date', '<=', $date)
                    ->get();
                if(!empty($user_repayment)){
                    if(count($user_repayment)>0){
                        $message =  "This month's loan has been paid";
                    }
                }
            }
        
            $user = Auth::user(); 
            $user = User::find($user->id)->with('user_loans', 'user_loans.user_repayments')->get();
            return response()->json(['message'=> $message,'success' => $user], $this-> successStatus); 
        }
    } 


    public function loan_duration() 
    { 
        $loan_duration = LoanDuration::all(); 
        return response()->json(['success' => $loan_duration], $this-> successStatus); 
    } 
    public function loan_repayment_frequency() 
    { 
        $loan_repayment_frequency = LoanRepaymentFrequency::all(); 
        return response()->json(['success' => $loan_repayment_frequency], $this-> successStatus); 
    } 
    public function loan_interest_rate() 
    { 
        $loan_interest_rate = LoanInterestRate::all(); 
        return response()->json(['success' => $loan_interest_rate], $this-> successStatus); 
    } 
    public function loan_arrangement_fee() 
    { 
        $loan_arrangement_fee = LoanArrangementFee::all(); 
        return response()->json(['success' => $loan_arrangement_fee], $this-> successStatus); 
    } 

}
