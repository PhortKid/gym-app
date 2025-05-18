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

Route::get('invoice',[CustomerManagementController::class,'invoice']);
Route::get('paid_customer',[CustomerManagementController::class,'paid_customer']);

Route::get('payment_report',[PaymentController::class,'report']);



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


Route::post('scan/{id}',function(Request $request,$id){
/*
    $user = Customer::find($id);
    
    if (!$user) {
        return response()->json(['status'=>'null','message' => 'User not found'], 404);
    }
   
    $attendance=new Attendance;
    $attendance->member_id =$id;
    $attendance->time_in =  Carbon::now();
    $attendance->save();
    return response()->json(['status'=>'success']);

    */

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




