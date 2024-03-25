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
        $first_date_query = $request->input('first_date');
        $second_date_query = $request->input('second_date');
        $date_query = Transaction::query();
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
        } else if ($first_date_query && $second_date_query) {
            $date_query->whereBetween('transaction_date', [$first_date_query, $second_date_query]);
            $incomeTable = DB::table('income')->get();
            $outcomeTable = DB::table('outcome')->get();
            $transactionTable = DB::table('transaction')->get();
            $results = $date_query->get();
            return view('home', compact('results', 'transactionTable', 'incomeTable', 'outcomeTable'));
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
