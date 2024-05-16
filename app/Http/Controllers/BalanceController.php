<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FirstBalance;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Transaction;
use App\Models\TotalBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    function postFirstBalance(Request $request)
    {
        $userId = Auth::id();
        $validateFirstBalance = FirstBalance::where('user_id', $userId)->count();

        if ($validateFirstBalance === 0) {
            $request->validate([
                'first_balance_amount' => 'required',
            ]);

            $firstBalance = new FirstBalance();
            $firstBalance->user_id = $userId;
            $firstBalance->first_balance_amount = $request->first_balance_amount;
            $firstBalance->save();

            $totalBalance = new TotalBalance();
            $totalBalance->user_id = $userId;
            $totalBalance->first_balance_id = $firstBalance->id;
            $totalBalance->transaction_id = null;
            $totalBalance->total_balance_amount = $request->first_balance_amount;
            $totalBalance->total_balance_date = now();
            $totalBalance->save();

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

        $userId = Auth::id();

        $income = new Income();
        $income->income_name = $request->income_name;
        $income->income_date = $request->income_date;
        $income->income_amount = $request->income_amount;
        $income->income_category = $request->income_category;
        $income->save();

        $transactionIncome = new Transaction();
        $transactionIncome->user_id = $userId;
        $transactionIncome->income_id = $income->id;
        $transactionIncome->outcome_id = null;
        $transactionIncome->transaction_date = $request->income_date;
        $transactionIncome->transaction_amount = $request->income_amount;
        $transactionIncome->transaction_type = 'income';
        $transactionIncome->save();

        $previousBalance = TotalBalance::where('user_id', $userId)->latest()->value('total_balance_amount');
        $newBalance = $previousBalance + $request->income_amount;

        $totalBalance = new TotalBalance();
        $totalBalance->user_id = $userId;
        $totalBalance->transaction_id = $transactionIncome->id;
        $totalBalance->first_balance_id = null;
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
            'outcome_amount' => 'required',
            'outcome_category' => 'nullable|string|max:255',
            'custom_category' => 'nullable|string|max:255'
        ]);

        $userId = Auth::id();

        $outcome = new Outcome();
        $outcome->outcome_name = $request->outcome_name;
        $outcome->outcome_date = $request->outcome_date;
        $outcome->outcome_amount = $request->outcome_amount;
        $outcome->outcome_category = $request->outcome_category;
        $outcome->save();

        $transactionOutcome = new Transaction();
        $transactionOutcome->user_id = $userId;
        $transactionOutcome->income_id = null;
        $transactionOutcome->outcome_id = $outcome->id;
        $transactionOutcome->transaction_date = $request->outcome_date;
        $transactionOutcome->transaction_amount = $request->outcome_amount;
        $transactionOutcome->transaction_type = 'outcome';
        $transactionOutcome->save();

        $previousBalance = TotalBalance::where('user_id', $userId)->latest()->value('total_balance_amount');
        $newBalance = $previousBalance - $request->outcome_amount;

        $totalBalance = new TotalBalance();
        $totalBalance->user_id = $userId;
        $totalBalance->transaction_id = $transactionOutcome->id;
        $totalBalance->first_balance_id = null;
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
            'income_amount' => 'nullable|numeric|max:999999999999'
        ]);

        $userId = Auth::id();

        $incomeData = Income::findOrFail($incomeId);

        $transactionData = Transaction::where('income_id', $incomeId)->first();
        if ($transactionData && $transactionData->user_id !== $userId) {
            abort(403, 'Unauthorized action.');
        }

        $oldIncomeAmount = $incomeData->income_amount;

        // Update Data Pendapatan
        $incomeData->update([
            'income_name' => $request->input('income_name', $incomeData->income_name),
            'income_date' => $request->input('income_date', $incomeData->income_date),
            'income_amount' => $request->input('income_amount', $incomeData->income_amount)
        ]);

        // Update Data Transaksi
        if ($transactionData) {
            $transactionData->update([
                'transaction_date' => $request->input('income_date', $transactionData->transaction_date),
                'transaction_amount' => $request->input('income_amount', $transactionData->transaction_amount)
            ]);
        }

        // Hitung perubahan jumlah pendapatan
        $changeAmount = $request->income_amount - $oldIncomeAmount;

        // Perbarui Total Balance
        $transactionIdsToUpdate = Transaction::where('user_id', $userId)
            ->where('id', '>=', $transactionData->id)
            ->pluck('id');

        TotalBalance::whereIn('transaction_id', $transactionIdsToUpdate)
            ->update([
                'total_balance_amount' => DB::raw("total_balance_amount + $changeAmount")
            ]);

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
            'outcome_amount' => 'nullable|numeric|max:999999999999' // Sesuaikan batas maksimalnya
        ]);

        $userId = Auth::id();

        // Ambil data outcome
        $outcomeData = Outcome::findOrFail($outcomeId);

        $transactionData = Transaction::where('outcome_id', $outcomeId)->first();
        if ($transactionData && $transactionData->user_id !== $userId) {
            abort(403, 'Unauthorized action.');
        }

        $oldOutcomeAmount = $outcomeData->outcome_amount;

        // Update Data Outcome
        $outcomeData->update([
            'outcome_name' => $request->input('outcome_name', $outcomeData->outcome_name),
            'outcome_date' => $request->input('outcome_date', $outcomeData->outcome_date),
            'outcome_amount' => $request->input('outcome_amount', $outcomeData->outcome_amount)
        ]);

        // Update Data Transaksi
        if ($transactionData) {
            $transactionData->update([
                'transaction_date' => $request->input('outcome_date', $transactionData->transaction_date),
                'transaction_amount' => $request->input('outcome_amount', $transactionData->transaction_amount)
            ]);
        }

        // Hitung perubahan jumlah pengeluaran
        $changeAmount = $request->outcome_amount - $oldOutcomeAmount;

        // Perbarui Total Balance
        $transactionIdsToUpdate = Transaction::where('user_id', $userId)
            ->where('id', '>=', $transactionData->id)
            ->pluck('id');

        TotalBalance::whereIn('transaction_id', $transactionIdsToUpdate)
            ->update([
                'total_balance_amount' => DB::raw("total_balance_amount - $changeAmount")
            ]);

        return redirect()->route('home');
    }
}
