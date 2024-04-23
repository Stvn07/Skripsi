<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'showHome'])->name('home');

Route::get('/home', function () {
    return view('sidebar\dashboard');
});

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

Route::post('/firstBalance', [BalanceController::class, 'postFirstBalance'])->name('openFirstBalance.post');

Route::post('/income', [BalanceController::class, 'postIncome'])->name('addIncome.post');

Route::post('/outcome', [BalanceController::class, 'postOutcome'])->name('addOutcome.post');

Route::get('/report', [ReportController::class, 'showReportTable'])->name('openReport');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
