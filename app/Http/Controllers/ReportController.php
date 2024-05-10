<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TotalBalance;
use Illuminate\Http\Request;
use App\Models\Transaction;


class reportController extends Controller
{
    function showReportTable(Request $request)
    {
        $userId = Auth::id();
        $bulan = $request->input('bulan');
        $year = date('Y', strtotime($bulan));
        $month = date('m', strtotime($bulan));
        $startDate = date("$year-$month-01");
        $endDate = date("Y-m-t", strtotime($startDate));
        $hasil_bulan = Transaction::with('Income', 'Outcome')
            ->where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('id')
            ->get();

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

        foreach ($hasil_bulan as $t) {
            $income_name = null;
            $outcome_name = null;
            $total_balance_per_day = 0;

            if ($t->income_id !== null) {
                $income_name = $t->Income->income_name;
                // Ambil total_balance_amount dari TotalBalance yang sesuai dengan income_id
                $total_balance_amount = TotalBalance::where('user_id', $userId)
                    ->where('transaction_id', $t->id)
                    ->where('total_balance_date', $t->transaction_date)
                    ->value('total_balance_amount');
            }

            if ($t->outcome_id !== null) {
                $outcome_name = $t->Outcome->outcome_name;
                // Ambil total_balance_amount dari TotalBalance yang sesuai dengan outcome_id
                $total_balance_amount = TotalBalance::where('user_id', $userId)
                    ->where('transaction_id', $t->id)
                    ->where('total_balance_date', $t->transaction_date)
                    ->value('total_balance_amount');
            }
            $t->total_balance_per_day = $total_balance_amount;
        }

        return view('cashflowReport', compact('hasil_bulan', 'total_income_bulan', 'total_outcome_bulan', 'total_final_balance_bulan'));
    }
}
