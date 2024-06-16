<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TotalBalance;
use Illuminate\Http\Request;
use App\Models\Transaction;


class reportController extends Controller
{
    function showReportTable(Request $request)
    {
        $userId = Auth::id();
        $bulan = $request->input('bulan') ?? date('Y-m');
        $year = date('Y', strtotime($bulan));
        $month = date('m', strtotime($bulan));
        $startDate = date("$year-$month-01");
        $endDate = date("Y-m-t", strtotime($startDate));
        $expensesByCategory = Transaction::select('outcome_category', DB::raw('SUM(transaction_amount) as total_amount'))
            ->join('outcome', 'transaction.outcome_id', '=', 'outcome.id')
            ->where('transaction.user_id', $userId)
            ->whereBetween('transaction.transaction_date', [$startDate, $endDate])
            ->groupBy('outcome.outcome_category')
            ->get();

        $incomesByCategory = Transaction::select('income_category', DB::raw('SUM(transaction_amount) as total_amount'))
            ->join('income', 'transaction.income_id', '=', 'income.id')
            ->where('transaction.user_id', $userId)
            ->whereBetween('transaction.transaction_date', [$startDate, $endDate])
            ->groupBy('income.income_category')
            ->get();

        // Menghitung total pengeluaran untuk setiap kategori
        $totalExpensesByCategory = [];
        foreach ($expensesByCategory as $expense) {
            $totalExpensesByCategory[$expense->outcome_category] = $expense->total_amount;
        }

        $totalIncomeByCategory = [];
        foreach ($incomesByCategory as $income) {
            $totalIncomeByCategory[$income->income_category] = $income->total_amount;
        }

        // Query untuk data transaksi
        $hasil_bulan = Transaction::with('Income', 'Outcome')
            ->where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('id')
            ->get();

        // Total income, outcome, dan balance
        $total_income_bulan = Transaction::where('user_id', $userId)
            ->where('transaction_type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('transaction_amount');

        $total_outcome_bulan = Transaction::where('user_id', $userId)
            ->where('transaction_type', 'outcome')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('transaction_amount');

        $total_final_balance_bulan = TotalBalance::where('user_id', $userId)
            ->whereBetween('total_balance_date', [$startDate, $endDate])
            ->latest()
            ->first();

        // Menghitung total_balance_per_day
        foreach ($hasil_bulan as $t) {
            $total_balance_per_day = TotalBalance::where('user_id', $userId)
                ->where('transaction_id', $t->id)
                ->where('total_balance_date', $t->transaction_date)
                ->value('total_balance_amount');

            $t->total_balance_per_day = $total_balance_per_day;
        }
        return view(
            'cashflowReport',
            compact(
                'hasil_bulan',
                'total_income_bulan',
                'total_outcome_bulan',
                'total_final_balance_bulan',
                'expensesByCategory',
                'totalExpensesByCategory',
                'incomesByCategory',
                'totalIncomeByCategory'
            )
        );
    }
}
