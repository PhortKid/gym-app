<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function pay(Request $request){
        Payment::create([
            'member_id'=>$request->member_id,
            'amount'=>$request->amount,
            'payment_method'=>$request->payment_method,
        ]);

        return redirect()->back();
    }
}
