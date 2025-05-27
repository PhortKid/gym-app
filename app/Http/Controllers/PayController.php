<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Models\Income;

class PayController extends Controller
{
    public function pay(Request $request){
        Payment::create([
            'member_id'=>$request->member_id,
            'amount'=>$request->amount,
            'payment_method'=>$request->payment_method,
            'date'=>$request->date,
        ]);

        $membershipCategory = IncomeCategory::firstOrCreate(['name' => 'Membership Revenue']);
        Income::create([
            'amount' => $request->amount,
            'description' => 'Membeship Revenue.',
            'date' => $request->date,
            'category_id' => $membershipCategory->id, 
            'payment_type' => $request->payment_method,
        ]);

        return redirect()->back();
    }
}
