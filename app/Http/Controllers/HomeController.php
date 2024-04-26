<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;

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
            $totalBalanceTable = $this->showTotalBalance();
            return view(
                'home',
                compact(
                    'searchResults',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable',
                    'totalBalanceTable'
                )
            );
        } else if ($start_date_query && $end_date_query) {
            $date_range_query->whereBetween('transaction_date', [$start_date_query, $end_date_query]);
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $results = $date_range_query->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            $totalBalanceTable = $this->showTotalBalance();
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable',
                    'totalBalanceTable'
                )
            );
        } else if ($one_date_query) {
            $date_query->whereDate('transaction_date', $one_date_query);
            $transactionTable = DB::table('transaction')->get();
            $incomeTable = $this->showIncomeTable();
            $outcomeTable = $this->showOutcomeTable();
            $one_date_results = $date_query->orderBy('id')->paginate(5, ['*'], 'page', null);
            $nomorUrut = ($one_date_results->currentPage() - 1) * $one_date_results->perPage() + 1;
            $totalBalanceTable = $this->showTotalBalance();
            foreach ($one_date_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'one_date_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable',
                    'totalBalanceTable'
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
            $totalBalanceTable = $this->showTotalBalance();
            foreach ($month_only_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'month_only_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable',
                    'totalBalanceTable'
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
            $totalBalanceTable = $this->showTotalBalance();
            foreach ($range_month_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'range_month_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable',
                    'totalBalanceTable'
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
            $totalBalanceTable = $this->showTotalBalance();
            foreach ($year_only_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'year_only_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable',
                    'totalBalanceTable'
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
            $totalBalanceTable = $this->showTotalBalance();
            foreach ($range_year_results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            return view(
                'home',
                compact(
                    'range_year_results',
                    'transactionTable',
                    'incomeTable',
                    'outcomeTable',
                    'totalBalanceTable'
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
            $totalBalanceTable = $this->showTotalBalance();
            $validateManyBalance = DB::table('first_balance')->count();
            $firstBalances = DB::table('first_balance')->get();
            return view(
                'home',
                compact(
                    'firstBalances',
                    'sumBalance',
                    'totalBalanceTable',
                    'incomeTable',
                    'outcomeTable',
                    'transactionTable',
                    'incomeBalance',
                    'outcomeBalance',
                    'validateManyBalance'
                )
            );
        }
    }

    function showIncomeTable()
    {
        $incomeTable = DB::table('income')->get();
        return $incomeTable;
    }

    function showOutcomeTable()
    {
        $outcomeTable = DB::table('outcome')->get();
        return $outcomeTable;
    }

    function showTotalBalance()
    {
        $sumBalance = DB::table('first_balance')->sum('first_balance_amount');
        $incomeBalance = DB::table('income')->sum('income_amount');
        $outcomeBalance = DB::table('outcome')->sum('outcome_amount');
        $manyBalance = DB::table('first_balance')->count();
        $totalBalance = 0;
        if ($manyBalance === 1) {
            $totalBalance = $sumBalance + ($incomeBalance - $outcomeBalance);
        }

        return $totalBalance;
    }

    public function showProfile($userId)
    {
        $userData = User::find($userId);
        $transactionData = Transaction::orderBy('created_at', 'desc')->take(3)->get();
        return view('user.profile', compact('userData', 'transactionData'));
    }

    public function showUpdateProfile($userId)
    {
        $userData = User::find($userId);
        return view('user.updateProfile', compact('userData'));
    }

    public function postUpdateProfile(Request $request, $id)
    {
        $request->validate([
            'user_full_name' => 'nullable|string|max:255',
            'user_email' => 'nullable|email',
            'user_address' => 'nullable|string|max:255',
            'user_phone_number' => 'nullable|string|max:12'
        ], [
            'user_full_name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'user_email.email' => 'Format email tidak valid.',
            'user_address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'user_phone_number.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
        ]);

        $userData = User::find($id);

        if (!$this->isDataChanged($userData, $request)) {
            return redirect()->back()->with('error', 'Gagal melakukan update, tidak ada perubahan data yang dilakukan.');
        }

        if ($request->filled('user_full_name')) {
            $userData->user_full_name = $request->user_full_name;
        }
        if ($request->filled('user_email')) {
            $userData->user_email = $request->user_email;
        }
        if ($request->filled('password')) {
            $userData->password = bcrypt($request->password);
        }
        if ($request->filled('user_address')) {
            $userData->user_address = $request->user_address;
        }
        if ($request->filled('user_phone_number')) {
            $userData->user_phone_number = $request->user_phone_number;
        }
        $userData->save();
        return redirect()->route('profile', $id)->with('success', 'Profil berhasil diperbarui!');
    }

    private function isDataChanged($user, $request)
    {
        $userData = $user->toArray();
        $requestData = $request->only(['user_full_name', 'user_email', 'user_address', 'user_phone_number']);

        return !empty(array_diff_assoc($requestData, $userData));
    }
}
