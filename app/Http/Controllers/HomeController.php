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
