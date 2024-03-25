<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Income;
use App\Models\Transaction;

class HomeController extends Controller
{
    //
    function showHome(Request $request)
    {
        $search_query = $request->query('search');
        $start_date_query = $request->input('start_date');
        $end_date_query = $request->input('end_date');
        $one_date_query = $request->input('one_date');
        $month_only_query = $request->input('month_only');
        $start_month_query = $request->input('start_month');
        $end_month_query = $request->input('end_month');
        $year_only_query = $request->input('year_only');
        $start_year_query = $request->input('start_year');
        $end_year_query = $request->input('end_year');
        $date_range_query = Transaction::query();
        $date_query = Transaction::query();
        $year = date('Y', strtotime($month_only_query));
        $month = date('m', strtotime($month_only_query));

        $start_year = date('Y', strtotime($start_month_query));
        $start_month = date('m', strtotime($start_month_query));
        $end_year = date('Y', strtotime($end_month_query));
        $end_month = date('m', strtotime($end_month_query));

        // $start_year_only = date('Y', strtotime($start_year_query));
        // $end_year_only = date('Y', strtotime($end_year_query));

        echo "<script>";
        // Write more JavaScript code
        echo "console.log($search_query);";

        echo "</script>";
        if ($search_query && $search_query != '') {
            $searchResults = DB::table('transaction')
                ->where('transaction_date', 'like', '%' . $search_query . '%')
                ->orWhere('transaction_amount', $search_query)
                ->orWhere('transaction_type', 'like', '%' . $search_query . '%')
                ->paginate(10)
                ->appends(['search' => $search_query]);
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            return view('home', compact('searchResults', 'transactionTable', 'incomeTable', 'outcomeTable'));
        } else if ($start_date_query && $end_date_query) {
            $date_range_query->whereBetween('transaction_date', [$start_date_query, $end_date_query]);
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            $results = $date_range_query->get();
            return view('home', compact('results', 'transactionTable', 'incomeTable', 'outcomeTable'));
        } else if ($one_date_query) {
            $date_query->whereDate('transaction_date', $one_date_query);
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            $one_date_results = $date_query->get();
            return view('home', compact('one_date_results', 'transactionTable', 'incomeTable', 'outcomeTable'));
        } else if ($month_only_query) {
            $startDate = date("$year-$month-01");
            $endDate = date("Y-m-t", strtotime($startDate));
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            $month_only_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->get();
            return view('home', compact('month_only_results', 'transactionTable', 'incomeTable', 'outcomeTable'));
        } else if ($start_month_query && $end_month_query) {
            $startDate = date("$start_year-$start_month-01");
            $endDate = date("$end_year-$end_month-t", strtotime($end_month));
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            $range_month_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->get();
            return view('home', compact('range_month_results', 'transactionTable', 'incomeTable', 'outcomeTable'));
        } else if ($year_only_query) {
            $startDate = date("$year_only_query-01-01");
            $endDate = date("$year_only_query-12-31");
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            $year_only_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->get();
            return view('home', compact('year_only_results', 'transactionTable', 'incomeTable', 'outcomeTable'));
        } else if ($start_year_query && $end_year_query) {
            $startDate = date("$start_year_query-01-01");
            $endDate = date("$end_year_query-12-31");
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            $range_year_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->get();
            return view('home', compact('range_year_results', 'transactionTable', 'incomeTable', 'outcomeTable'));
        } else {
            $sumBalance = DB::table('first_balance')->sum('first_balance_amount');
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $incomeBalance = DB::table('income')->sum('income_amount');
            $outcomeBalance = DB::table('outcome')->sum('outcome_amount');
            $totalBalance = DB::table('total_balance')->sum('total_balance_amount');
            $transactionTable = DB::table('transaction')->get();
            $incomeTableJan = DB::table('income')->whereMonth('income_date', '03')->sum('income_amount');
            $manyBalance = DB::table('first_balance')->count();
            if ($manyBalance === 1) {
                $totalBalance = $sumBalance + $incomeBalance - $outcomeBalance;
            } else {
                $totalBalance = 0;
            }
            $firstBalances = DB::table('first_balance')->get();
            return view('home', compact('firstBalances', 'sumBalance', 'totalBalance', 'manyBalance', 'incomeTable', 'incomeTableJan', 'outcomeTable', 'transactionTable'));
        }
    }
}
