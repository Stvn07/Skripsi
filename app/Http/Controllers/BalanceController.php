<?php

namespace App\Http\Controllers;

use App;
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
            'income_amount' => 'required',
            'income_category' => 'nullable|string|max:255'
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

    function showIncomePage(Request $request)
    {
        $userId = Auth::id();
        $locale = App::getLocale();
        $date_query = Transaction::query();
        $date_query->where('user_id', $userId);
        $search_query = $request->query('search');
        $initialTransactionsCount = Transaction::where('user_id', $userId)->whereNull('outcome_id')
            ->with('Income')->count();

        $date_only_query = $request->input('one_date');
        $start_date_query = $request->input('start_date');
        $end_date_query = $request->input('end_date');

        $month_only_query = $request->input('month_only');
        $year = date('Y', strtotime($month_only_query));
        $month = date('m', strtotime($month_only_query));

        $start_month_query = $request->input('start_month');
        $end_month_query = $request->input('end_month');
        $start_year = date('Y', strtotime($start_month_query));
        $start_month = date('m', strtotime($start_month_query));
        $end_year = date('Y', strtotime($end_month_query));
        $end_month = date('m', strtotime($end_month_query));

        $year_only_query = $request->input('year_only');
        $start_year_query = $request->input('start_year');
        $end_year_query = $request->input('end_year');

        if ($search_query && $search_query != '') {
            $results = Transaction::with(['Income'])
                ->where('user_id', $userId)
                ->where(function ($query) use ($search_query) {
                    $query->WhereHas('Income', function ($query) use ($search_query) {
                        $query->where('income_name', 'like', '%' . $search_query . '%');
                    })
                        ->orWhereHas('Income', function ($query) use ($search_query) {
                            $query->where('income_amount', 'like', '%' . $search_query . '%');
                        })
                        ->orWhereHas('Income', function ($query) use ($search_query) {
                            $query->where('income_date', 'like', '%' . $search_query . '%');
                        })
                        ->orWhereHas('Income', function ($query) use ($search_query) {
                            $query->where('income_category', 'like', '%' . $search_query . '%');
                        });
                })
                ->orderBy('id')
                ->paginate(10)
                ->appends(['search' => $search_query]);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            $hasil = $date_query->get();
        } else if ($date_only_query) {
            $date_query->whereNull('outcome_id')->with(['Income'])->whereDate('transaction_date', $date_only_query);
            $results = $date_query->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->income_id = $result->Income->id;
                    $result->income_name = $result->Income->income_name;
                    $result->income_date = $result->Income->income_date;
                    $result->income_category = $result->Income->income_category;
                    $result->income_amount = $result->Income->income_amount;
                } else {
                    $result->income_id = null;
                    $result->income_name = null;
                    $result->income_date = null;
                    $result->income_category = null;
                    $result->income_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_date_query && $end_date_query) {
            $date_query->whereNull('outcome_id')->with(['Income'])->whereBetween('transaction_date', [$start_date_query, $end_date_query]);
            $results = $date_query->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->income_id = $result->Income->id;
                    $result->income_name = $result->Income->income_name;
                    $result->income_date = $result->Income->income_date;
                    $result->income_category = $result->Income->income_category;
                    $result->income_amount = $result->Income->income_amount;
                } else {
                    $result->income_id = $result->Income->id;
                    $result->income_name = $result->Income->income_name;
                    $result->income_date = $result->Income->income_date;
                    $result->income_category = $result->Income->income_category;
                    $result->income_amount = $result->Income->income_amount;
                }
            }
            $hasil = $date_query->get();
        } else if ($month_only_query) {
            $startDate = date("$year-$month-01");
            $endDate = date("Y-m-t", strtotime($startDate));
            $results = $date_query->whereNull('outcome_id')->with(['Income'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->income_id = $result->Income->id;
                    $result->income_name = $result->Income->income_name;
                    $result->income_date = $result->Income->income_date;
                    $result->income_category = $result->Income->income_category;
                    $result->income_amount = $result->Income->income_amount;
                } else {
                    $result->income_id = null;
                    $result->income_name = null;
                    $result->income_date = null;
                    $result->income_category = null;
                    $result->income_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_month_query && $end_month_query) {
            $startDate = date("$start_year-$start_month-01");
            $endDate = date("$end_year-$end_month-t", strtotime($end_month));
            $results = $date_query->whereNull('outcome_id')->with(['Income'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->income_id = $result->Income->id;
                    $result->income_name = $result->Income->income_name;
                    $result->income_date = $result->Income->income_date;
                    $result->income_category = $result->Income->income_category;
                    $result->income_amount = $result->Income->income_amount;
                } else {
                    $result->income_id = null;
                    $result->income_name = null;
                    $result->income_date = null;
                    $result->income_category = null;
                    $result->income_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($year_only_query) {
            $startDate = date("$year_only_query-01-01");
            $endDate = date("$year_only_query-12-31");
            $results = $date_query->whereNull('outcome_id')->with(['Income'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->income_id = $result->Income->id;
                    $result->income_name = $result->Income->income_name;
                    $result->income_date = $result->Income->income_date;
                    $result->income_category = $result->Income->income_category;
                    $result->income_amount = $result->Income->income_amount;
                } else {
                    $result->income_id = null;
                    $result->income_name = null;
                    $result->income_date = null;
                    $result->income_category = null;
                    $result->income_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_year_query && $end_year_query) {
            $startDate = date("$start_year_query-01-01");
            $endDate = date("$end_year_query-12-31");
            $results = $date_query->whereNull('outcome_id')->with(['Income'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->income_id = $result->Income->id;
                    $result->income_name = $result->Income->income_name;
                    $result->income_date = $result->Income->income_date;
                    $result->income_category = $result->Income->income_category;
                    $result->income_amount = $result->Income->income_amount;
                } else {
                    $result->income_id = null;
                    $result->income_name = null;
                    $result->income_date = null;
                    $result->income_category = null;
                    $result->income_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else {
            $results = Transaction::where('user_id', $userId)
                ->whereNull('outcome_id')
                ->with('Income')
                ->orderBy('transaction_date')
                ->paginate(10);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            $hasil = $date_query->get();
        }
        $errorMessage = null;
        if ($results->count() === 0) {
            if ($initialTransactionsCount === 0) {
                if ($locale === 'id') {
                    $errorMessage = "Belum ada pendapatan yang ditambahkan";
                } else {
                    $errorMessage = "No income added yet";
                }
            } else {
                if ($locale === 'id') {
                    $errorMessage = "Pendapatan tidak ditemukan";
                } else {
                    $errorMessage = "Income Not Found";
                }
            }
        }
        return view('income', compact('results', 'hasil', 'errorMessage'));
    }

    function postOutcome(Request $request)
    {
        $request->validate([
            'outcome_name' => 'required',
            'outcome_date' => 'required|date',
            'outcome_amount' => 'required',
            'outcome_category' => 'nullable|string|max:255'
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

    function showOutcomePage(Request $request)
    {
        $userId = Auth::id();
        $locale = App::getLocale();
        $date_query = Transaction::query();
        $date_query->where('user_id', $userId);
        $search_query = $request->query('search');
        $initialTransactionsCount = Transaction::where('user_id', $userId)->whereNull('income_id')
            ->with('Outcome')->count();

        $date_only_query = $request->input('one_date');
        $start_date_query = $request->input('start_date');
        $end_date_query = $request->input('end_date');

        $month_only_query = $request->input('month_only');
        $year = date('Y', strtotime($month_only_query));
        $month = date('m', strtotime($month_only_query));

        $start_month_query = $request->input('start_month');
        $end_month_query = $request->input('end_month');
        $start_year = date('Y', strtotime($start_month_query));
        $start_month = date('m', strtotime($start_month_query));
        $end_year = date('Y', strtotime($end_month_query));
        $end_month = date('m', strtotime($end_month_query));

        $year_only_query = $request->input('year_only');
        $start_year_query = $request->input('start_year');
        $end_year_query = $request->input('end_year');

        if ($search_query && $search_query != '') {
            $results = Transaction::with(['Outcome'])
                ->where('user_id', $userId)
                ->where(function ($query) use ($search_query) {
                    $query->WhereHas('Outcome', function ($query) use ($search_query) {
                        $query->where('outcome_name', 'like', '%' . $search_query . '%');
                    })
                        ->orWhereHas('Outcome', function ($query) use ($search_query) {
                            $query->where('outcome_amount', 'like', '%' . $search_query . '%');
                        })
                        ->orWhereHas('Outcome', function ($query) use ($search_query) {
                            $query->where('outcome_date', 'like', '%' . $search_query . '%');
                        })
                        ->orWhereHas('Outcome', function ($query) use ($search_query) {
                            $query->where('outcome_category', 'like', '%' . $search_query . '%');
                        });
                })
                ->orderBy('id')
                ->paginate(10)
                ->appends(['search' => $search_query]);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            $hasil = $date_query->get();
        } else if ($date_only_query) {
            $date_query->whereNull('income_id')->with(['Outcome'])->whereDate('transaction_date', $date_only_query);
            $results = $date_query->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Outcome) {
                    $result->outcome_id = $result->Outcome->id;
                    $result->outcome_name = $result->Outcome->outcome_name;
                    $result->outcome_date = $result->Outcome->outcome_date;
                    $result->outcome_category = $result->Outcome->outcome_category;
                    $result->outcome_amount = $result->Outcome->outcome_amount;
                } else {
                    $result->outcome_id = null;
                    $result->outcome_name = null;
                    $result->outcome_date = null;
                    $result->outcome_category = null;
                    $result->outcome_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_date_query && $end_date_query) {
            $date_query->whereNull('income_id')->with(['Outcome'])->whereBetween('transaction_date', [$start_date_query, $end_date_query]);
            $results = $date_query->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Outcome) {
                    $result->outcome_id = $result->Outcome->id;
                    $result->outcome_name = $result->Outcome->outcome_name;
                    $result->outcome_date = $result->Outcome->outcome_date;
                    $result->outcome_category = $result->Outcome->outcome_category;
                    $result->outcome_amount = $result->Outcome->outcome_amount;
                } else {
                    $result->outcome_id = $result->Outcome->id;
                    $result->outcome_name = $result->Outcome->outcome_name;
                    $result->outcome_date = $result->Outcome->outcome_date;
                    $result->outcome_category = $result->Outcome->outcome_category;
                    $result->outcome_amount = $result->Outcome->outcome_amount;
                }
            }
            $hasil = $date_query->get();
        } else if ($month_only_query) {
            $startDate = date("$year-$month-01");
            $endDate = date("Y-m-t", strtotime($startDate));
            $results = $date_query->whereNull('income_id')->with(['Outcome'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Outcome) {
                    $result->outcome_id = $result->Outcome->id;
                    $result->outcome_name = $result->Outcome->outcome_name;
                    $result->outcome_date = $result->Outcome->outcome_date;
                    $result->outcome_category = $result->Outcome->outcome_category;
                    $result->outcome_amount = $result->Outcome->outcome_amount;
                } else {
                    $result->outcome_id = null;
                    $result->outcome_name = null;
                    $result->outcome_date = null;
                    $result->outcome_category = null;
                    $result->outcome_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_month_query && $end_month_query) {
            $startDate = date("$start_year-$start_month-01");
            $endDate = date("$end_year-$end_month-t", strtotime($end_month));
            $results = $date_query->whereNull('income_id')->with(['Outcome'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Outcome) {
                    $result->outcome_id = $result->Outcome->id;
                    $result->outcome_name = $result->Outcome->outcome_name;
                    $result->outcome_date = $result->Outcome->outcome_date;
                    $result->outcome_category = $result->Outcome->outcome_category;
                    $result->outcome_amount = $result->Outcome->outcome_amount;
                } else {
                    $result->outcome_id = null;
                    $result->outcome_name = null;
                    $result->outcome_date = null;
                    $result->outcome_category = null;
                    $result->outcome_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($year_only_query) {
            $startDate = date("$year_only_query-01-01");
            $endDate = date("$year_only_query-12-31");
            $results = $date_query->whereNull('income_id')->with(['Outcome'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Outcome) {
                    $result->outcome_id = $result->Outcome->id;
                    $result->outcome_name = $result->Outcome->outcome_name;
                    $result->outcome_date = $result->Outcome->outcome_date;
                    $result->outcome_category = $result->Outcome->outcome_category;
                    $result->outcome_amount = $result->Outcome->outcome_amount;
                } else {
                    $result->outcome_id = null;
                    $result->outcome_name = null;
                    $result->outcome_date = null;
                    $result->outcome_category = null;
                    $result->outcome_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_year_query && $end_year_query) {
            $startDate = date("$start_year_query-01-01");
            $endDate = date("$end_year_query-12-31");
            $results = $date_query->whereNull('income_id')->with(['Outcome'])->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Outcome) {
                    $result->outcome_id = $result->Outcome->id;
                    $result->outcome_name = $result->Outcome->outcome_name;
                    $result->outcome_date = $result->Outcome->outcome_date;
                    $result->outcome_category = $result->Outcome->outcome_category;
                    $result->outcome_amount = $result->Outcome->outcome_amount;
                } else {
                    $result->outcome_id = null;
                    $result->outcome_name = null;
                    $result->outcome_date = null;
                    $result->outcome_category = null;
                    $result->outcome_amount = null;
                }
            }
            $hasil = $date_query->get();
        } else {
            $results = Transaction::where('user_id', $userId)
                ->whereNull('income_id')
                ->with('Outcome')
                ->orderBy('transaction_date')
                ->paginate(10);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
            }
            $hasil = $date_query->get();
        }
        $errorMessage = null;
        if ($results->count() === 0) {
            if ($initialTransactionsCount === 0) {
                if ($locale === 'id') {
                    $errorMessage = "Belum ada pengeluaran yang ditambahkan";
                } else {
                    $errorMessage = "No outflow added yet";
                }
            } else {
                if ($locale === 'id') {
                    $errorMessage = "Pengeluaran tidak ditemukan";
                } else {
                    $errorMessage = "Outflow Not Found";
                }
            }
        }
        return view('outcome', compact('results', 'hasil', 'errorMessage'));
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
            'income_amount' => 'nullable|numeric|max:999999999999',
            'income_category' => 'nullable|string|max:255'
        ]);

        $userId = Auth::id();

        $transaction = Transaction::where('income_id', $incomeId)->firstOrFail();
        $transactions = Transaction::where('income_id', $incomeId)->get();

        $incomeData = Income::findOrFail($incomeId);
        $oldIncomeAmount = $incomeData->income_amount;

        $incomeData->update([
            'income_name' => $request->input('income_name', $incomeData->income_name),
            'income_date' => $request->input('income_date', $incomeData->income_date),
            'income_amount' => $request->input('income_amount', $incomeData->income_amount),
            'income_category' => $request->input('income_category', $incomeData->income_category)
        ]);

        foreach ($transactions as $transactionData) {
            $transactionData->update([
                'transaction_date' => $request->input('income_date', $transactionData->transaction_date),
                'transaction_amount' => $request->input('income_amount', $transactionData->transaction_amount)
            ]);
        }

        $changeAmount = $request->income_amount - $oldIncomeAmount;

        if ($transactions->isNotEmpty()) {
            $transactionIdsToUpdate = Transaction::where('user_id', $userId)
                ->where('id', '>=', $transactions->first()->id)
                ->pluck('id');

            TotalBalance::whereIn('transaction_id', $transactionIdsToUpdate)
                ->update([
                    'total_balance_amount' => DB::raw("total_balance_amount + $changeAmount")
                ]);
        }

        return redirect()->route('openIncomePage');
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
            'outcome_amount' => 'nullable|numeric|max:999999999999',
            'outcome_category' => 'nullable|string|max:255'
        ]);

        $userId = Auth::id();

        $transaction = Transaction::where('outcome_id', $outcomeId)->firstOrFail();
        $transactions = Transaction::where('outcome_id', $outcomeId)->get();

        $outcomeData = Outcome::findOrFail($outcomeId);
        $oldOutcomeAmount = $outcomeData->outcome_amount;

        $outcomeData->update([
            'outcome_name' => $request->input('outcome_name', $outcomeData->outcome_name),
            'outcome_date' => $request->input('outcome_date', $outcomeData->outcome_date),
            'outcome_amount' => $request->input('outcome_amount', $outcomeData->outcome_amount),
            'outcome_category' => $request->input('outcome_category', $outcomeData->outcome_category)
        ]);

        foreach ($transactions as $transactionData) {
            $transactionData->update([
                'transaction_date' => $request->input('outcome_date', $transactionData->transaction_date),
                'transaction_amount' => $request->input('outcome_amount', $transactionData->transaction_amount)
            ]);
        }

        $changeAmount = $request->outcome_amount - $oldOutcomeAmount;

        if ($transactions->isNotEmpty()) {
            $transactionIdsToUpdate = Transaction::where('user_id', $userId)
                ->where('id', '>=', $transactions->first()->id)
                ->pluck('id');

            TotalBalance::whereIn('transaction_id', $transactionIdsToUpdate)
                ->update([
                    'total_balance_amount' => DB::raw("total_balance_amount - $changeAmount")
                ]);
        }

        return redirect()->route('openOutcomePage');
    }
}
