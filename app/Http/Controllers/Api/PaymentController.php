<?php

namespace App\Http\Controllers\Api;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
    

public function report()
{
        $report = Payment::select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get();
    
        return response()->json($report);
    
}

}
