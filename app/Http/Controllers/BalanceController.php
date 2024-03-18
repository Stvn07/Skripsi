<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FirstBalance;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    //
    function postFirstBalance(Request $request) {
        $validateManyBalance = DB::table('first_balance')->count();
        if ($validateManyBalance < 0) {
            $request->validate([
                'first_balance_amount' => 'required',
            ]);

            $data['first_balance_amount'] = $request->first_balance_amount;
            $firstBalance = FirstBalance::create($data);
            if(!$firstBalance){
                return redirect(route('openFirstBalance'))->with("error", "Please Input Data Correctly");
            }
            return redirect(route('home'))->with("success", "Success Input The Firsyt Balance");
        }
        else {
            return redirect(route('home'))->with("error", "The First Balance Can Only Be Input Once");
        }
    }

    function openFirstBalance() {
        return view('balance.firstBalance');
    }
}
