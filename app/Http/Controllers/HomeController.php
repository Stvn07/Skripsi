<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TotalBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\Transaction;
use App\Models\Income;
use App\Models\User;
use App\Models\FirstBalance;

class HomeController extends Controller
{

    public function changeLanguage($locale)
    {
        App::setLocale($locale);
        Session::put('locale', $locale);
        Cookie::queue('locale', $locale, 60 * 24 * 30);

        return redirect()->back();
    }

    function showHome(Request $request)
    {
        $userId = Auth::id();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $transactionTable = Transaction::paginate(10);
        $incomeChart = $this->showIncomeChart();
        $outcomeChart = $this->showOutcomeChart();
        $statusName = $this->countStatusOutcome();
        $transactionData = Transaction::where('user_id', $userId)->orderBy('created_at', 'desc')->take(3)->get();
        $hasFirstBalance = FirstBalance::where('user_id', $userId)->exists();
        $nomorUrut = ($transactionTable->currentPage() - 1) * $transactionTable->perPage() + 1;
        foreach ($transactionTable as $result) {
            $result->nomor_urut = $nomorUrut++;
        }
        $totalBalanceTable = $this->showTotalBalance();
        $total_income_per_month = Transaction::where('user_id', $userId)
            ->where('transaction_type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('transaction_amount');

        $total_outcome_per_month = Transaction::where('user_id', $userId)
            ->where('transaction_type', 'outcome')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('transaction_amount');
        return view(
            'home',
            compact(
                'totalBalanceTable',
                'transactionTable',
                'incomeChart',
                'outcomeChart',
                'total_income_per_month',
                'total_outcome_per_month',
                'statusName',
                'transactionData',
                'hasFirstBalance'
            )
        );
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

    function showIncomeChart()
    {
        $userId = Auth::id();
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // Inisialisasi data untuk chart
        $data = [
            'charts' => []
        ];

        // Loop untuk setiap hari dalam bulan ini dengan langkah 3 hari
        for ($day = $startOfMonth->copy(); $day->lte($endOfMonth); $day->addDays(3)) {
            // Hitung rentang waktu untuk 3 hari ini
            $endOfPeriod = $day->copy()->addDays(2);
            if ($endOfPeriod->gt($endOfMonth)) {
                $endOfPeriod = $endOfMonth;
            }

            // Ambil data untuk periode ini
            $outcomeTable = Transaction::select(DB::raw('DATE(transaction_date) as transaction_date'), DB::raw('SUM(transaction_amount) as total_amount'))
                ->where('user_id', $userId)
                ->whereNull('outcome_id')
                ->whereBetween('transaction_date', [$day, $endOfPeriod])
                ->groupBy('transaction_date')
                ->get();

            // Inisialisasi label dan jumlah untuk periode ini
            $labels = [];
            $amount = [];

            // Loop untuk setiap hari dalam periode ini
            for ($periodDay = $day->copy(); $periodDay->lte($endOfPeriod); $periodDay->addDay()) {
                // Format label untuk hari
                $labels[] = $periodDay->format('l, d F Y');

                // Cari total pengeluaran untuk hari ini
                $totalAmountForDay = $outcomeTable->where('transaction_date', $periodDay->toDateString())->sum('total_amount');
                $amount[] = $totalAmountForDay;
            }

            // Simpan data periode ini ke dalam array charts
            $data['charts'][] = [
                'labels' => $labels,
                'amount' => $amount
            ];
        }

        return $data;
    }

    function showOutcomeChart()
    {
        $userId = Auth::id();
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // Inisialisasi data untuk chart
        $data = [
            'charts' => []
        ];

        // Hitung jumlah minggu dalam bulan ini
        for ($day = $startOfMonth->copy(); $day->lte($endOfMonth); $day->addDays(3)) {
            // Hitung rentang waktu untuk 3 hari ini
            $endOfPeriod = $day->copy()->addDays(2);
            if ($endOfPeriod->gt($endOfMonth)) {
                $endOfPeriod = $endOfMonth;
            }

            // Ambil data untuk periode ini
            $outcomeTable = Transaction::select(DB::raw('DATE(transaction_date) as transaction_date'), DB::raw('SUM(transaction_amount) as total_amount'))
                ->where('user_id', $userId)
                ->whereNull('income_id')
                ->whereBetween('transaction_date', [$day, $endOfPeriod])
                ->groupBy('transaction_date')
                ->get();

            // Inisialisasi label dan jumlah untuk periode ini
            $labels = [];
            $amount = [];

            // Loop untuk setiap hari dalam periode ini
            for ($periodDay = $day->copy(); $periodDay->lte($endOfPeriod); $periodDay->addDay()) {
                // Format label untuk hari
                $labels[] = $periodDay->format('l, d F Y');

                // Cari total pengeluaran untuk hari ini
                $totalAmountForDay = $outcomeTable->where('transaction_date', $periodDay->toDateString())->sum('total_amount');
                $amount[] = $totalAmountForDay;
            }

            // Simpan data periode ini ke dalam array charts
            $data['charts'][] = [
                'labels' => $labels,
                'amount' => $amount
            ];
        }

        return $data;
    }

    function showTotalBalance()
    {
        $userId = Auth::id();
        $sumBalance = FirstBalance::where('user_id', $userId)->sum('first_balance_amount');
        $incomeBalance = Transaction::where('user_id', $userId)->where('transaction_type', 'income')->sum('transaction_amount');
        $outcomeBalance = Transaction::where('user_id', $userId)->where('transaction_type', 'outcome')->sum('transaction_amount');
        $totalBalance = $sumBalance + ($incomeBalance - $outcomeBalance);

        return $totalBalance;
    }

    public function showProfile($userId)
    {
        $userData = User::find($userId);
        $userAuth = Auth::id();
        $transactionData = Transaction::where('user_id', $userAuth)->orderBy('created_at', 'desc')->take(3)->get();
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

    function countStatusOutcome()
    {
        $userId = Auth::id();
        $locale = App::getLocale();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $statusOutcome = '';
        $totalBalanceAmount = TotalBalance::where('user_id', $userId)
            ->whereNull('first_balance_id')
            ->latest('created_at')
            ->first();

        if ($totalBalanceAmount === null) {
            if ($locale === 'id') {
                $statusOutcome = 'Belum Ada Pengeluaran';
            } else {
                $statusOutcome = 'No Spending';
            }
        } else {
            $outcomeExpenses = Transaction::where('user_id', $userId)
                ->whereNull('income_id')
                ->sum('transaction_amount');

            $total_income_per_month = Transaction::where('user_id', $userId)
                ->where('transaction_type', 'income')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('transaction_amount');

            $total_outcome_per_month = Transaction::where('user_id', $userId)
                ->where('transaction_type', 'outcome')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('transaction_amount');

            // $remainingAmount = $totalBalanceAmount->total_balance_amount;
            // $percentage = ($outcomeExpenses / $remainingAmount) * 100;
            $percentage = ($total_outcome_per_month / $total_income_per_month) * 100;
            $lowExpenses = 30;
            $middleExpenses = 65;

            if ($percentage < $lowExpenses) {
                if ($locale === 'id') {
                    $statusOutcome = 'Pengeluaran Rendah';
                } else {
                    $statusOutcome = 'Low Spending';
                }
            } else if ($percentage <= $middleExpenses) {
                if ($locale === 'id') {
                    $statusOutcome = 'Pengeluaran Sedang';
                } else {
                    $statusOutcome = 'Medium Spending';
                }
            } else {
                if ($locale === 'id') {
                    $statusOutcome = 'Pengeluaran Tinggi';
                } else {
                    $statusOutcome = 'High Spending';
                }
            }
        }
        return $statusOutcome;
    }

}
