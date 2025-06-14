<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\CustomerManagementController;
use App\Http\Controllers\Api\MembershipPlanController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\IncomeCategoryController;
use App\Http\Controllers\Api\ExpenseCategoryController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\AttendanceTrackingController;



use Carbon\Carbon;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
});


Route::post('/register', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('app-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
});



Route::get('customer',[CustomerManagementController::class,'customers']);
Route::post('add_customer',[CustomerManagementController::class,'add']);
Route::post('delete_customer/{id}', [CustomerManagementController::class, 'delete']);

Route::get('invoice',[CustomerManagementController::class,'invoice']);
Route::get('unpaid',[CustomerManagementController::class,'unpaid']);
Route::get('paid_customer',[CustomerManagementController::class,'paid_customer']);

Route::get('payment_report',[PaymentController::class,'report']);
Route::get('all_attendance',[AttendanceTrackingController::class,'allCustomersAttendance']);




//membership plan
Route::get('membership_plan',[MembershipPlanController::class,'all']);
Route::post('add_membership_plan',[MembershipPlanController::class,'add']);
Route::post('update_membership_plan/{id}', [MembershipPlanController::class, 'update']);
Route::post('delete_membership_plan/{id}', [MembershipPlanController::class, 'delete']);

//User
Route::get('users',[UsersController::class,'all']);
Route::get('trainer',[UsersController::class,'trainer']);
Route::post('add_user',[UsersController::class,'add']);
Route::post('update_user/{id}', [UsersController::class, 'update']);
Route::post('delete_user/{id}', [UsersController::class, 'delete']);

//Attendance
Route::get('attendance',[AttendanceController::class,'all']);
Route::post('add_attendance',[AttendanceController::class,'add']);
Route::post('update_attendance/{id}', [AttendanceController::class, 'update']);
Route::post('delete_attendance/{id}', [AttendanceController::class, 'delete']);

//IncomeCategoryController
Route::get('income_category',[IncomeCategoryController::class,'all']);
Route::post('add_income_category',[IncomeCategoryController::class,'add']);
Route::post('update_income_category/{id}', [IncomeCategoryController::class, 'update']);
Route::post('delete_income_category/{id}', [IncomeCategoryController::class, 'delete']);

//IncomeController
Route::get('income',[IncomeController::class,'all']);
Route::post('add_income',[IncomeController::class,'add']);
Route::post('update_income/{id}', [IncomeController::class, 'update']);
Route::post('delete_income/{id}', [IncomeController::class, 'delete']);

//ExpenseCategoryController
Route::get('expense_category',[ExpenseCategoryController::class,'all']);
Route::post('add_expense_category',[ExpenseCategoryController::class,'add']);
Route::post('update_expense_category/{id}', [ExpenseCategoryController::class, 'update']);
Route::post('delete_expense_category/{id}', [ExpenseCategoryController::class, 'delete']);

//Expense
Route::get('expense',[ExpenseController::class,'all']);
Route::post('add_expense',[ExpenseController::class,'add']);
Route::post('update_expense/{id}', [ExpenseController::class, 'update']);
Route::post('delete_expense/{id}', [ExpenseController::class, 'delete']);


Route::post('scan/{id}',function(Request $request,$id){
    $user = Customer::find($id);
    
    if (!$user) {
        return response()->json(['status' => 'null', 'message' => 'User not found'], 404);
    }

    $attendance = new Attendance;
    $attendance->member_id = $id;
    $attendance->time_in = Carbon::now();
    $attendance->save();

    return response()->json([
        'status' => 'success',
        'user' => [
            'full_name'     => $user->full_name,
            'gender'        => $user->gender,
            'phone_number'  => $user->phone_number,
            'email'         => $user->email,
            'nationality'   => $user->nationality,
            'address'       => $user->address,
            'start_date'    => $user->start_date,
            'expiry_date'   => $user->expiry_date,
        ]
    ]);


});

use App\Http\Controllers\Api\ReportController;

Route::get('/reports/income-summary', [ReportController::class, 'incomeSummary']);
Route::get('/reports/expense-summary', [ReportController::class, 'expenseSummary']);

Route::post('add_payment', [PaymentController::class, 'add_payment']);//add payment
Route::get('payments', [PaymentController::class, 'index']);





Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->json(['message' => 'Logged out successfully']);
});
