<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Attendance;
use App\Models\Customer;

Route::get('/', function () {

    $dailyCount = Attendance::whereDate('time_in', today())->count();
    $monthlyCount = Attendance::whereMonth('time_in', now()->month)->count();
    $yearlyCount = Attendance::whereYear('time_in', now()->year)->count();

    $dailyMember = Customer::whereDate('start_date', today())->count();
    $monthlyMember = Customer::whereMonth('start_date', now()->month)->count();
    $yearlyMember = Customer::whereYear('start_date', now()->year)->count();

    return view('welcome',compact('dailyCount','monthlyCount', 'yearlyCount','dailyMember','monthlyMember', 'yearlyMember'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/demo',function(){
    $update=Customer::find('1');
    $update->start_date="2025-05-9";
    $update->expiry_date="2025-05-10";
    $update->save();
});

Route::view('users','workspace.users_management.index');
Route::view('trainer','workspace.users_management.trainer');
Route::view('paid_customer','workspace.customer_management.paid');
Route::view('invoice','workspace.customer_management.invoice');
Route::view('customer','workspace.customer_management.index');
Route::view('membership_plan','workspace.membership_plan.index');
Route::view('attendance','workspace.attendance.index');
Route::view('attendance_tracking','workspace.attendance_tracking.index');
Route::view('income','workspace.income.index');
Route::view('expense','workspace.expense.index');
Route::view('financial_report','workspace.reports.financial_report');
Route::view('income_category','workspace.income_category.index');
Route::view('expense_category','workspace.expense_category.index');
Route::view('payment_report','workspace.reports.payment_report');
Route::view('signin', 'signin')->name('signin');


use Illuminate\Support\Facades\Mail;

Route::get('/scann', function () {
    
   return view('scan');

});

Route::get('/myqrcode/{id}', function (Request $request,$id) {
    

    return view('myqrcode',compact('id'));

    
 
 });

 Route::get('/signout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/signin');  
})->name('signout');



require __DIR__.'/auth.php';
