<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Income;

class HomeController extends Controller
{
    //
    function showHome() {
            $sumBalance = DB::table('first_balance')->sum('first_balance_amount');
            $incomeTable = DB::table('income')->get();
            $incomeTableJan = DB::table('income')->whereMonth('income_date', '03')->sum('income_amount');
            $averageBalance = DB::table('first_balance')->avg('first_balance_amount');
            $manyBalance = DB::table('first_balance')->count();
            if ($manyBalance === 1) {
                $totalBalance = $sumBalance + $averageBalance;
            } else {
                $totalBalance = 0;
            }
            $firstBalances = DB::table('first_balance')->get();
            return view('home', compact('firstBalances', 'sumBalance', 'averageBalance', 'totalBalance', 'manyBalance', 'incomeTable', 'incomeTableJan'));
    }
}
