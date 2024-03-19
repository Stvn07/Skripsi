<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FirstBalance;
use App\Models\Income;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    //
    function postFirstBalance(Request $request) {
        $validateManyBalance = DB::table('first_balance')->count();
        if ($validateManyBalance < 0) {
            $request->validate([
                'first_balance_amount' => 'required',
            ]);

            $data['first_balance_amount'] = $request->first_balance_amount;
            $firstBalance = FirstBalance::create($data);
            if(!$firstBalance){
                return redirect(route('openFirstBalance'))->with("error", "Please Input Data Correctly");
            }
            return redirect(route('home'))->with("success", "Success Input The First Balance");
        }
        else {
            return redirect(route('home'))->with("error", "The First Balance Can Only Be Input Once");
        }
    }

    function openFirstBalance() {
        return view('balance.firstBalance');
    }

    function openAddIncome() {
        return view('balance.income');
    }

    function postIncome(Request $request) {
        $request->validate([
            'income_name' => 'required',
            'income_date' => 'required|date',
            'income_amount' => 'required'
        ]);

        $data['income_name'] = $request->income_name;
        $data['income_date'] = $request->income_date;
        $data['income_amount'] = $request->income_amount;
        $income = Income::create($data);
        if(!$income){
            return redirect(route('addIncome'))->with("error", "Please Input Data Correctly");
        }
        return redirect(route('home'))->with("success", "Success Input The First Balance");
    }

    function openAddOutcome() {

    }

    function postOutcome(Request $request) {
        $request->validate([
            'outcome_name' => 'required',
            'outcome_date' => 'required|date',
            'outcome_amount' => 'required'
        ]);

        $data['outcome_name'] = $request->outcome_name;
        $data['outcome_date'] = $request->outcome_date;
        $data['outcome_amount'] = $request->outcome_amount;
        $income = Income::create($data);
        if(!$income){
            return redirect(route('addIncome'))->with("error", "Please Input Data Correctly");
        }
        return redirect(route('home'))->with("success", "Success Input The First Balance");
    }
}
