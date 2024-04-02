<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Income;
use App\Models\Outcome;

class HomeController extends Controller
{
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

        if ($search_query && $search_query != '') {
            $searchResults = DB::table('transaction')
                ->where('transaction_date', 'like', '%' . $search_query . '%')
                ->orWhere('transaction_amount', $search_query)
                ->orWhere('transaction_type', 'like', '%' . $search_query . '%')
                ->orderBy('id')
                ->paginate(5, ['*'], 'page', null)
                ->appends(['search' => $search_query]);
            $nomorUrut = ($searchResults->currentPage() - 1) * $searchResults->perPage() + 1;
            foreach ($searchResults as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            return view(
                'home',
                compact(
                    'searchResults',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable'
                )
            );
        } else if ($start_date_query && $end_date_query) {
            $date_range_query->whereBetween('transaction_date', [$start_date_query, $end_date_query]);
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $results = $date_range_query->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable'
                )
            );
        } else if ($one_date_query) {
            $date_query->whereDate('transaction_date', $one_date_query);
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $one_date_results = $date_query->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($one_date_results->currentPage() - 1) * $one_date_results->perPage() + 1;
            foreach ($one_date_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'one_date_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable'
                )
            );
        } else if ($month_only_query) {
            $startDate = date("$year-$month-01");
            $endDate = date("Y-m-t", strtotime($startDate));
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $month_only_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($month_only_results->currentPage() - 1) * $month_only_results->perPage() + 1;
            foreach ($month_only_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'month_only_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable'
                )
            );
        } else if ($start_month_query && $end_month_query) {
            $startDate = date("$start_year-$start_month-01");
            $endDate = date("$end_year-$end_month-t", strtotime($end_month));
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $range_month_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($range_month_results->currentPage() - 1) * $range_month_results->perPage() + 1;
            foreach ($range_month_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'range_month_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable'
                )
            );
        } else if ($year_only_query) {
            $startDate = date("$year_only_query-01-01");
            $endDate = date("$year_only_query-12-31");
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $year_only_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($year_only_results->currentPage() - 1) * $year_only_results->perPage() + 1;
            foreach ($year_only_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'year_only_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable'
                )
            );
        } else if ($start_year_query && $end_year_query) {
            $startDate = date("$start_year_query-01-01");
            $endDate = date("$end_year_query-12-31");
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $range_year_results = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($range_year_results->currentPage() - 1) * $range_year_results->perPage() + 1;
            foreach ($range_year_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'range_year_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable'
                )
            );
        } else {
            $sumBalance = DB::table('first_balance')->sum('first_balance_amount');
            $incomeBalance = DB::table('income')->sum('income_amount');
            $outcomeBalance = DB::table('outcome')->sum('outcome_amount');
            $totalBalance = DB::table('total_balance')->sum('total_balance_amount');
            $transactionTable = Transaction::paginate(5);
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $nomorUrut = ($transactionTable->currentPage() - 1) * $transactionTable->perPage() + 1;
            foreach ($transactionTable as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            $incomeTableJan = DB::table('income')->whereMonth('income_date', '03')->sum('income_amount');
            $manyBalance = DB::table('first_balance')->count();
            if ($manyBalance === 1) {
                $totalBalance = $sumBalance + ($incomeBalance - $outcomeBalance);
            }
            $firstBalances = DB::table('first_balance')->get();
            return view(
                'home',
                compact(
                    'firstBalances',
                    'sumBalance',
                    'totalBalance',
                    'manyBalance',
                    'incomeTable',
                    'outcomeTable',
                    'incomeTableJan',
                    'transactionTable',
                    'incomeBalance',
                    'outcomeBalance'
                )
            );
        }
    }

    function showIncomeTable()
    {
        // $incomeTable = Income::paginate(5);
        $incomeTable = DB::table('income')->get();

        return $incomeTable;
    }

    function showOutcomeTable()
    {
        // $outcomeTable = Outcome::paginate(5);
        $outcomeTable = DB::table('outcome')->get();

        return $outcomeTable;
    }
}
