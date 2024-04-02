<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FirstBalance;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Transaction;
use App\Models\TotalBalance;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    function postFirstBalance(Request $request)
    {
        $validateManyBalance = DB::table('first_balance')->count();
        if ($validateManyBalance === 0) {
            $request->validate([
                'first_balance_amount' => 'required',
            ]);
            $firstBalance = new FirstBalance();
            $firstBalance->first_balance_amount = $request->first_balance_amount;
            $firstBalance->save();
            $totalBalance = new TotalBalance();
            $totalBalance->first_balance_id = $firstBalance->id;
            $totalBalance->income_id = null;
            $totalBalance->outcome_id = null;
            $totalBalance->total_balance_amount = $request->first_balance_amount;
            $totalBalance->total_balance_date = new \DateTime();
            $totalBalance->save();
            if (!$firstBalance) {
                return redirect(route('openFirstBalance'))->with("error", "Please Input Data Correctly");
            }
            return redirect(route('home'))->with("success", "Success Input The First Balance");
        } else {
            return redirect(route('home'))->with("error", "The First Balance Can Only Be Input Once");
        }
    }

    function postIncome(Request $request)
    {
        $request->validate([
            'income_name' => 'required',
            'income_date' => 'required|date',
            'income_amount' => 'required'
        ]);
        $income = new Income();
        $income->income_name = $request->income_name;
        $income->income_date = $request->income_date;
        $income->income_amount = $request->income_amount;
        $income->save();
        $transactionIncome = new Transaction();
        $transactionIncome->income_id = $income->id;
        $transactionIncome->outcome_id = null;
        $transactionIncome->transaction_date = $request->income_date;
        $transactionIncome->transaction_amount = $request->income_amount;
        $transactionIncome->transaction_type = 'income';
        $transactionIncome->save();
        if (!$income) {
            return redirect(route('addIncome'))->with("error", "Please Input Data Correctly");
        }
        return redirect(route('home'))->with("success", "Success Input The First Balance");
    }

    function postOutcome(Request $request)
    {
        $request->validate([
            'outcome_name' => 'required',
            'outcome_date' => 'required|date',
            'outcome_amount' => 'required'
        ]);

        $outcome = new Outcome();
        $outcome->outcome_name = $request->outcome_name;
        $outcome->outcome_date = $request->outcome_date;
        $outcome->outcome_amount = $request->outcome_amount;
        $outcome->save();
        $transactionOutcome = new Transaction();
        $transactionOutcome->income_id = null;
        $transactionOutcome->outcome_id = $outcome->id;
        $transactionOutcome->transaction_date = $request->outcome_date;
        $transactionOutcome->transaction_amount = $request->outcome_amount;
        $transactionOutcome->transaction_type = 'outcome';
        $transactionOutcome->save();
        if (!$outcome) {
            return redirect(route('addOutcome'))->with("error", "Please Input Data Correctly");
        }
        return redirect(route('home'))->with("success", "Success Input The First Balance");
    }

    function updatePostIncome(Request $request, $id)
    {
        $request->validate([
            'income_name' => 'required',
            'income_date' => 'required|date',
            'income_amount' => 'required'
        ]);
        $newIncome = Income::find($id);
        $newIncome->income_name = $request->income_name;
        $newIncome->income_date = $request->income_date;
        $newIncome->income_amount = $request->income_amount;
        $newIncome->save();
        $newTransactionIncome = Transaction::find($id);
        $newTransactionIncome->income_id = $newIncome->id;
        $newTransactionIncome->outcome_id = null;
        $newTransactionIncome->transaction_date = $request->income_date;
        $newTransactionIncome->transaction_amount = $request->income_amount;
        $newTransactionIncome->transaction_type = 'income';
        $newTransactionIncome->save();
        return redirect(route('home'));

    }

    function updatePostOutcome(Request $request, $id)
    {
        $request->validate([
            'outcome_name' => 'required',
            'outcome_date' => 'required|date',
            'outcome_amount' => 'required'
        ]);
        $newOutcome = Outcome::find($id);
        $newOutcome->outcome_name = $request->outcome_name;
        $newOutcome->outcome_date = $request->outcome_date;
        $newOutcome->outcome_amount = $request->outcome_amount;
        $newOutcome->save();
        $newTransactionOutcome = Transaction::find($id);
        $newTransactionOutcome->income_id = null;
        $newTransactionOutcome->outcome_id = $newOutcome->id;
        $newTransactionOutcome->transaction_date = $request->outcome_date;
        $newTransactionOutcome->transaction_amount = $request->outcome_amount;
        $newTransactionOutcome->transaction_type = 'outcome';
        $newTransactionOutcome->save();
        return redirect(route('home'));
    }
}
