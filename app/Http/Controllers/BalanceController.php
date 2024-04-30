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
            $totalBalance->total_balance_date = now();
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

        $previousBalance = TotalBalance::latest()->value('total_balance_amount');
        $newBalance = $previousBalance + $request->income_amount;

        $totalBalance = new TotalBalance();
        $totalBalance->first_balance_id = null;
        $totalBalance->income_id = $income->id;
        $totalBalance->outcome_id = null;
        $totalBalance->transaction_id = $transactionIncome->id;
        $totalBalance->total_balance_amount = $newBalance;
        $totalBalance->total_balance_date = $request->income_date;
        $totalBalance->save();

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

        $previousBalance = TotalBalance::latest()->value('total_balance_amount');
        $newBalance = $previousBalance - $request->outcome_amount;

        $totalBalance = new TotalBalance();
        $totalBalance->first_balance_id = null;
        $totalBalance->income_id = null;
        $totalBalance->outcome_id = $outcome->id;
        $totalBalance->transaction_id = $transactionOutcome->id;
        $totalBalance->total_balance_amount = $newBalance;
        $totalBalance->total_balance_date = $request->outcome_date;
        $totalBalance->save();

        if (!$outcome) {
            return redirect(route('addOutcome'))->with("error", "Please Input Data Correctly");
        }
        return redirect(route('home'))->with("success", "Success Input The First Balance");
    }

    function openUpdateIncome($incomeId)
    {
        $incomeData = Income::find($incomeId);

        return view('update.updateIncome', compact('incomeData'));
    }

    function updateIncome(Request $request, $incomeId)
    {
        $request->validate([
            'income_name' => 'nullable|string|max:255',
            'income_date' => 'nullable|date',
            'income_amount' => 'nullable|max_digits:12'
        ]);

        $incomeData = Income::findOrFail($incomeId);
        $oldIncomeAmount = $incomeData->income_amount;

        //Update Data Income
        $incomeData->income_name = $request->input('income_name', $incomeData->income_name);
        $incomeData->income_date = $request->input('income_date', $incomeData->income_date);
        $incomeData->income_amount = $request->input('income_amount', $incomeData->income_amount);
        $incomeData->save();

        //Update Data Transaksi
        $transactionData = Transaction::where('income_id', $incomeId)->first();
        if ($transactionData) {
            $transactionData->transaction_date = $request->input('income_date', $transactionData->transaction_date);
            $transactionData->transaction_amount = $request->input('income_amount', $transactionData->transaction_amount);
            $transactionData->save();
        }

        //Update Data Total Balance
        $changeAmount = $request->income_amount - $oldIncomeAmount;
        $totalBalanceToUpdate = TotalBalance::where('income_id', $incomeData->id)->first();
        $totalBalances = TotalBalance::where('id', '>=', $totalBalanceToUpdate->id)->orderBy('id')->get();

        foreach ($totalBalances as $totalBalance) {
            $totalBalance->total_balance_amount += $changeAmount;
            $totalBalance->save();
        }

        return redirect()->route('home');
    }

    function openUpdateOutcome($outcomeId)
    {
        $outcomeData = Outcome::find($outcomeId);

        return view('update.updateOutcome', compact('outcomeData'));
    }

    function updateOutcome(Request $request, $outcomeId)
    {
        $request->validate([
            'outcome_name' => 'nullable|string|max:255',
            'outcome_date' => 'nullable|date',
            'outcome_amount' => 'nullable|max_digits:12'
        ]);

        $outcomeData = Outcome::findOrFail($outcomeId);
        $oldOutcomeAmount = $outcomeData->outcome_amount;

        // Update Data Outcome
        $outcomeData->outcome_name = $request->input('outcome_name', $outcomeData->outcome_name);
        $outcomeData->outcome_date = $request->input('outcome_date', $outcomeData->outcome_date);
        $outcomeData->outcome_amount = $request->input('outcome_amount', $outcomeData->outcome_amount);
        $outcomeData->save();

        // Update Data Transaction
        $transactionData = Transaction::where('outcome_id', $outcomeId)->first();
        if ($transactionData) {
            $transactionData->transaction_date = $request->input('outcome_date', $transactionData->transaction_date);
            $transactionData->transaction_amount = $request->input('outcome_amount', $transactionData->transaction_amount);
            $transactionData->save();
        }

        // Update Data Total Balance
        $changeAmount = $oldOutcomeAmount - $request->outcome_amount;
        $totalBalanceToUpdate = TotalBalance::where('outcome_id', $outcomeData->id)->first();
        $totalBalances = TotalBalance::where('id', '>=', $totalBalanceToUpdate->id)->orderBy('id')->get();

        foreach ($totalBalances as $totalBalance) {
            $totalBalance->total_balance_amount += $changeAmount;
            $totalBalance->save();
        }

        return redirect()->route('home');
    }
}
