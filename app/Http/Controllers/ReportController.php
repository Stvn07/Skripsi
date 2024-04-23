<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Income;
use App\Models\Outcome;


class reportController extends Controller
{
    //
    function showReportTable(Request $request)
    {
        $bulan = $request->input('bulan');
        $year = date('Y', strtotime($bulan));
        $month = date('m', strtotime($bulan));
        $startDate = date("$year-$month-01");
        $endDate = date("Y-m-t", strtotime($startDate));
        $hasil_bulan =
            Transaction::with('Income', 'Outcome')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->orderBy('transaction_date')->get()
        ;
        $total_income_bulan = Income::whereBetween('income_date', [$startDate, $endDate])
            ->sum('income_amount');
        $total_outcome_bulan = Outcome::whereBetween('outcome_date', [$startDate, $endDate])
            ->sum('outcome_amount');
        // $total_balance_bulan = $total_balance + $total_income_bulan - $total_outcome_bulan;

        $total_balance = DB::table('total_balance')->sum('total_balance_amount');
        foreach ($hasil_bulan as $t) {
            $income_name = null;
            $outcome_name = null;
            $income_amount = 0;
            $outcome_amount = 0;

            if ($t->Income !== null) {
                $income_name = $t->Income->income_name;
                $income_amount += $t->Income->income_amount;
                $total_balance += $t->Income->income_amount;
            }

            if ($t->Outcome !== null) {
                $outcome_name = $t->Outcome->outcome_name;
                $outcome_amount += $t->Outcome->outcome_amount;
                $total_balance -= $t->Outcome->outcome_amount;
            }
        }

        return view('cashflowReport', compact('hasil_bulan', 'total_income_bulan', 'total_outcome_bulan', 'total_balance_bulan'));
    }
}
