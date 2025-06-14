<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Attendance;
use App\Models\Customer;
use App\Models\Payment;
use App\Http\Controllers\ExpectedIncomeController;
use App\Http\Controllers\ProjectedExpenseController;
use App\Http\Controllers\SalaryManagement;
use App\Http\Controllers\IncomeReportController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\SystemInfoController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AttendanceChartController;

use App\Services\BMIService;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\InvoiceController;

Route::resource('invoices', InvoiceController::class);



    Route::get('/fix-membership-type', function () {
    DB::statement('ALTER TABLE customers DROP FOREIGN KEY customers_membership_type_id_foreign');
    DB::statement('ALTER TABLE customers MODIFY membership_type_id BIGINT UNSIGNED NULL');
    DB::statement('ALTER TABLE customers ADD CONSTRAINT customers_membership_type_id_foreign FOREIGN KEY (membership_type_id) REFERENCES membership_plans(id)');

    return 'Membership type column updated successfully!';
});











Route::get('/attendance/chart', [AttendanceChartController::class, 'attendanceChart']);

Route::resource('sales', SaleController::class)->except(['show', 'edit', 'update']);
Route::resource('products', ProductController::class)->except(['show']);
Route::get('/sales/report', [SaleController::class, 'report'])->name('sales.report');


Route::resource('system-info', SystemInfoController::class);

Route::get('/', function () {

    $dailyCount = Attendance::whereDate('time_in', today())->count();
    $monthlyCount = Attendance::whereMonth('time_in', now()->month)->count();
    $yearlyCount = Attendance::whereYear('time_in', now()->year)->count();

    $dailyMember = Customer::whereDate('start_date', today())->count();
    $monthlyMember = Customer::whereMonth('start_date', now()->month)->count();
    $yearlyMember = Customer::whereYear('start_date', now()->year)->count();

    return view('welcome',compact('dailyCount','monthlyCount', 'yearlyCount','dailyMember','monthlyMember', 'yearlyMember'));
})->middleware('auth');

Route::middleware('auth')->group(function () { //auth middleware
 

Route::view('users','workspace.users_management.index');
Route::view('trainer','workspace.users_management.trainer');
Route::view('paid_customer','workspace.customer_management.paid');
Route::view('invoice','workspace.customer_management.invoice');
Route::view('unpaid','workspace.customer_management.unpaid');
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

Route::get('/product-report', [ReportController::class, 'productReport']);
Route::get('/financial_summary', [ReportController::class,'financialSummary'])->name('report.financial_summary');

Route::resource('/expected_incomes', ExpectedIncomeController::class);
Route::resource('/projected_expenses', ProjectedExpenseController::class);

Route::resource('/salary_management', SalaryManagement::class);
Route::get('/salary_report', [SalaryManagement::class,'salaryReport'])->name('salary_management.salaryReport');

Route::get('/report/income', [IncomeReportController::class, 'show'])->name('income.report');
Route::get('/report/expense', [ExpenseReportController::class, 'show'])->name('expense.report');

//report
Route::get('/income_expense', [ReportController::class, 'income_expense'])->name('income_expense.report');

Route::post('/pay', [PayController::class, 'pay'])->name('pay');








});// end of auth middleware
Route::view('signin', 'signin')->name('signin');
Route::post('/signin', [SigninController::class, 'login']);

Route::get('/demo',function(){
    

return  Payment::all();
});







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


Route::get('receipt/{id}',function(Request $request, $id){
    $customer=Customer::where('card_number',$id)->first();

    $receiptUrl = url("/receipt/{$customer->card_number}");
    $qrCode = QrCode::size(200)
        ->backgroundColor(255, 255, 255)
        ->margin(1)
        ->generate($receiptUrl);

    return view('workspace.customer_management.thermal_receipt',compact('customer','qrCode'));
});






require __DIR__.'/auth.php';
