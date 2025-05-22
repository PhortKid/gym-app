<?php

namespace App\Http\Controllers\Api;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    

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
