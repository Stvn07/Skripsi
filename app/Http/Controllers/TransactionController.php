<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    function showTransaction(Request $request)
    {
        $userId = Auth::id();
        $locale = App::getLocale();
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
        $date_query = Transaction::query();
        $date_query->where('user_id', $userId);
        $initialTransactionsCount = Transaction::where('user_id', $userId)->count();

        // Untuk Filter Bagian Bulan Saja
        $year = date('Y', strtotime($month_only_query));
        $month = date('m', strtotime($month_only_query));

        // Untuk Filter Bagian Range Bulan
        $start_year = date('Y', strtotime($start_month_query));
        $start_month = date('m', strtotime($start_month_query));
        $end_year = date('Y', strtotime($end_month_query));
        $end_month = date('m', strtotime($end_month_query));

        if ($locale == 'id') {
            if (strpos(strtolower($search_query), 'pendapatan') !== false) {
                $search_query = str_ireplace('pendapatan', 'income', $search_query);
            } elseif (strpos(strtolower($search_query), 'pengeluaran') !== false) {
                $search_query = str_ireplace('pengeluaran', 'outcome', $search_query);
            }
        }

        if ($search_query && $search_query != '') {
            $results = Transaction::with(['Income', 'Outcome'])
                ->where('user_id', $userId)
                ->where(function ($query) use ($search_query) {
                    $query->where('transaction_date', 'like', '%' . $search_query . '%')
                        ->orWhere('transaction_amount', 'like', '%' . $search_query . '%')
                        ->orWhere('transaction_type', 'like', '%' . $search_query . '%')
                        ->orWhereHas('Income', function ($query) use ($search_query) {
                            $query->where('income_name', 'like', '%' . $search_query . '%');
                        })
                        ->orWhereHas('Outcome', function ($query) use ($search_query) {
                            $query->where('outcome_name', 'like', '%' . $search_query . '%');
                        });
                })
                ->orderBy('id')
                ->paginate(10)
                ->appends(['search' => $search_query]);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_date_query && $end_date_query) {
            $date_query->whereBetween('transaction_date', [$start_date_query, $end_date_query]);
            $results = $date_query->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($one_date_query) {
            $date_query->whereDate('transaction_date', $one_date_query);
            $results = $date_query->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($month_only_query) {
            $startDate = date("$year-$month-01");
            $endDate = date("Y-m-t", strtotime($startDate));
            $results = $date_query->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_month_query && $end_month_query) {
            $startDate = date("$start_year-$start_month-01");
            $endDate = date("$end_year-$end_month-t", strtotime($end_month));
            $results = $date_query->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($year_only_query) {
            $startDate = date("$year_only_query-01-01");
            $endDate = date("$year_only_query-12-31");
            $results = $date_query->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        } else if ($start_year_query && $end_year_query) {
            $startDate = date("$start_year_query-01-01");
            $endDate = date("$end_year_query-12-31");
            $results = $date_query->whereBetween('transaction_date', [$startDate, $endDate])->orderBy('id')->paginate(10, ['*'], 'page', null);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        } else {
            $results = Transaction::where('user_id', $userId)->orderBy('id', 'desc')->paginate(10);
            $nomorUrut = ($results->currentPage() - 1) * $results->perPage() + 1;
            foreach ($results as $result) {
                $result->nomor_urut = $nomorUrut++;
                if ($result->Income) {
                    $result->transaction_name = $result->Income->income_name;
                } elseif ($result->Outcome) {
                    $result->transaction_name = $result->Outcome->outcome_name;
                } else {
                    $result->transaction_name = null;
                }
            }
            $hasil = $date_query->get();
        }
        $errorMessage = null;
        if ($results->count() === 0) {
            if ($initialTransactionsCount === 0) {
                if ($locale === 'id') {
                    $errorMessage = "Belum ada transaksi yang ditambahkan";
                } else {
                    $errorMessage = "No Transaction Added yet";
                }
            } else {
                if ($locale === 'id') {
                    $errorMessage = "Transaksi tidak ditemukan";
                } else {
                    $errorMessage = "Transaction Not Found";
                }
            }
        }
        return view(
            'transaction',
            compact(
                'results',
                'errorMessage',
                'hasil'
            )
        );
    }
}
