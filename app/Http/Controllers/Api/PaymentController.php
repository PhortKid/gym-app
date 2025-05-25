<?php

namespace App\Http\Controllers\Api;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index() 
    {
        return response()->json(Payment::all());
    }

    public function add_payment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pay_member_id' => 'required',
            'pay_payment_method' => 'required',
            'pay_amount' => 'required',
            'pay_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $payments=Payment::create([
        'member_id'=>$request->pay_member_id,
        'payment_method'=>$request->pay_payment_method,
        'amount'=>$request->pay_amount,
        'payment_date'=>$request->pay_date,
        ]);



       return response()->json(['status' => 'success', 'message' => 'Payment Added']);
    }

public function report(Request $request)
{
    
        $filter = $request->input('filter', 'daily'); // default daily
    
        if ($filter === 'daily') {
            $startDate = Carbon::today()->startOfDay();
            $endDate = Carbon::today()->endOfDay();
        } elseif ($filter === 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filter === 'yearly') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } else {
            $startDate = Carbon::today()->startOfDay();
            $endDate = Carbon::today()->endOfDay();
        }
    
        $report = Payment::select('payment_method', DB::raw('SUM(amount) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->get();
    
        return response()->json($report);
    
}

}
