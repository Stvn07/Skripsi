<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', [HomeController::class, 'showHome'])->name('home')->middleware('checkLogin');
Route::get('/profile/{userId}', [HomeController::class, 'showProfile'])->name('profile');
Route::get('/profile/update/{userId}', [HomeController::class, 'showUpdateProfile'])->name('updateProfile');
Route::post('/profile/update/{userId}', [HomeController::class, 'postUpdateProfile'])->name('updateProfile.post');
Route::get('/home', function () {
    return view('sidebar\dashboard');
});

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');


Route::post('/firstBalance', [BalanceController::class, 'postFirstBalance'])->name('openFirstBalance.post')->middleware('checkLogin');
Route::post('/income', [BalanceController::class, 'postIncome'])->name('addIncome.post')->middleware('checkLogin');
Route::get('/income/update/{incomeId}', [BalanceController::class, 'openUpdateIncome'])->name('updateIncome')->middleware('checkLogin');
Route::post('/income/update/{incomeId}', [BalanceController::class, 'updateIncome'])->name('updateIncome.post')->middleware('checkLogin');
Route::post('/outcome', [BalanceController::class, 'postOutcome'])->name('addOutcome.post')->middleware('checkLogin');
Route::get('/outcome/update/{outcomeId}', [BalanceController::class, 'openUpdateOutcome'])->name('updateOutcome')->middleware('checkLogin');
Route::post('/outcome/update/{outcomeId}', [BalanceController::class, 'updateOutcome'])->name('updateOutcome.post')->middleware('checkLogin');

Route::get('/transaction', [TransactionController::class, 'showTransaction'])->name('openTransaction')->middleware('checkLogin');
Route::get('/report', [ReportController::class, 'showReportTable'])->name('openReport')->middleware('checkLogin');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
