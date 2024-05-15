<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TotalBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\User;
use App\Models\FirstBalance;

class HomeController extends Controller
{
    function showHome(Request $request)
    {
        $userId = Auth::id();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $transactionTable = Transaction::paginate(5);
        $incomeTable = $this->showIncomeTable();
        $outcomeTable = $this->showOutcomeTable();
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
                'incomeTable',
                'outcomeTable',
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

    function showIncomeTable()
    {
        $userId = Auth::id();
        $incomeTable = Transaction::where('user_id', $userId)
            ->whereNull('outcome_id')
            ->with('Income')
            ->orderBy('transaction_date')
            ->get();
        $number = 1;
        foreach ($incomeTable as $income) {
            $income->number = $number++;
        }
        return $incomeTable;
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

        // Hitung jumlah minggu dalam bulan ini
        $totalWeeks = $endOfMonth->diffInWeeks($startOfMonth);

        // Loop untuk setiap minggu dalam bulan ini
        for ($week = 0; $week < $totalWeeks; $week++) {
            // Hitung rentang waktu untuk minggu ini
            $startOfWeek = $startOfMonth->copy()->addWeeks($week)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();

            // Ambil data untuk minggu ini
            $outcomeTable = Transaction::select(DB::raw('DATE(transaction_date) as transaction_date'), DB::raw('SUM(transaction_amount) as total_amount'))
                ->where('user_id', $userId)
                ->whereNull('outcome_id')
                ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
                ->groupBy('transaction_date')
                ->get();

            // Inisialisasi label dan jumlah untuk minggu ini
            $labels = [];
            $amount = [];

            // Loop untuk setiap hari dalam minggu ini
            for ($day = $startOfWeek->copy(); $day->lte($endOfWeek); $day->addDay()) {
                // Format label untuk hari
                $labels[] = $day->format('l, d F Y');

                // Cari total pengeluaran untuk hari ini
                $totalAmountForDay = $outcomeTable->where('transaction_date', $day->toDateString())->sum('total_amount');
                $amount[] = $totalAmountForDay;
            }

            // Simpan data minggu ini ke dalam array charts
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
        $totalWeeks = $endOfMonth->diffInWeeks($startOfMonth);

        // Loop untuk setiap minggu dalam bulan ini
        for ($week = 0; $week < $totalWeeks; $week++) {
            // Hitung rentang waktu untuk minggu ini
            $startOfWeek = $startOfMonth->copy()->addWeeks($week)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();

            // Ambil data untuk minggu ini
            $outcomeTable = Transaction::select(DB::raw('DATE(transaction_date) as transaction_date'), DB::raw('SUM(transaction_amount) as total_amount'))
                ->where('user_id', $userId)
                ->whereNull('income_id')
                ->whereBetween('transaction_date', [$startOfWeek, $endOfWeek])
                ->groupBy('transaction_date')
                ->get();

            // Inisialisasi label dan jumlah untuk minggu ini
            $labels = [];
            $amount = [];

            // Loop untuk setiap hari dalam minggu ini
            for ($day = $startOfWeek->copy(); $day->lte($endOfWeek); $day->addDay()) {
                // Format label untuk hari
                $labels[] = $day->format('l, d F Y');

                // Cari total pengeluaran untuk hari ini
                $totalAmountForDay = $outcomeTable->where('transaction_date', $day->toDateString())->sum('total_amount');
                $amount[] = $totalAmountForDay;
            }

            // Simpan data minggu ini ke dalam array charts
            $data['charts'][] = [
                'labels' => $labels,
                'amount' => $amount
            ];
        }

        return $data;
    }

    function showOutcomeTable()
    {
        $userId = Auth::id();
        $outcomeTable = Transaction::where('user_id', $userId)
            ->whereNull('income_id')
            ->with('Outcome')
            ->orderBy('transaction_date')
            ->get();
        $number = 1;
        foreach ($outcomeTable as $outcome) {
            $outcome->number = $number++;
        }
        return $outcomeTable;
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

    function countStatusOutcome()
    {
        $userId = Auth::id();
        $statusOutcome = '';
        $totalBalanceAmount = TotalBalance::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        if ($totalBalanceAmount === null) {
            $statusOutcome = 'Belum Ada Pengeluaran';
        } else {
            $outcomeExpenses = Transaction::where('user_id', $userId)
                ->whereNull('income_id')
                ->sum('transaction_amount');
            $remainingAmount = $totalBalanceAmount->total_balance_amount;
            $percentage = ($outcomeExpenses / $remainingAmount) * 100;
            $lowExpenses = 25;
            $middleExpenses = 50;

            if ($percentage < $lowExpenses) {
                $statusOutcome = 'Pengeluaran Rendah';
            } else if ($percentage <= $middleExpenses) {
                $statusOutcome = 'Pengeluaran Sedang';
            } else {
                $statusOutcome = 'Pengeluaran Tinggi';
            }
        }
        return $statusOutcome;
    }

}
