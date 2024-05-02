<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TotalBalance;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Income;
use App\Models\Outcome;


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
        $hasil_bulan =
            Transaction::with('Income', 'Outcome', 'TotalBalance')
                ->where('user_id', $userId)
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->orderBy('id')->get()
        ;
        $total_income_bulan = Income::where('user_id', $userId)->whereBetween('income_date', [$startDate, $endDate])
            ->sum('income_amount');
        $total_outcome_bulan = Outcome::where('user_id', $userId)->whereBetween('outcome_date', [$startDate, $endDate])
            ->sum('outcome_amount');
        $total_final_balance_bulan = TotalBalance::where('user_id', $userId)->whereBetween('total_balance_date', [$startDate, $endDate])
            ->latest()->first();

        foreach ($hasil_bulan as $t) {
            $income_name = null;
            $outcome_name = null;
            $total_balance_per_day = 0;

            if ($t->Income !== null) {
                $income_name = $t->Income->income_name;
                $total_balance_amount = $t->TotalBalance->total_balance_amount;
            }

            if ($t->Outcome !== null) {
                $outcome_name = $t->Outcome->outcome_name;
                $total_balance_amount = $t->TotalBalance->total_balance_amount;
            }
        }

        return view('cashflowReport', compact('hasil_bulan', 'total_income_bulan', 'total_outcome_bulan', 'total_final_balance_bulan'));
    }
}
