<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    
    public function all(){
        return response()->json(Expense::with(['category','income_category'])->get());
    }

    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'receipt_number'=>'required',
            'payment_method'=>'required',
            'description'=>'nullable',
            'amount'=>'required',
            'date'=>'required',
            'category_id'=>'required',
            'status'=>'required',
            'payed_to'=>'required',
            'income_id'=>'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Expense::create(
            [
                'receipt_number'=>$request->receipt_number,
                'payment_method'=>$request->payment_method,
                'description'=>$request->description,
                'amount'=>$request->amount,
                'date'=>$request->date,
                'category_id'=>$request->category_id,
                'status'=>$request->status,
                'payed_to'=>$request->payed_to,
                'income_id'=>$request->income_id,
        ]);
        return response()->json(['status'=>'sucess','message'=>'Expense Added']);
      
    }

    public function update(Request $request, $id)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'receipt_number'=>'required',
        'payment_method'=>'required',
        'description'=>'nullable',
        'amount'=>'required',
        'date'=>'required',
        'category_id'=>'required',
        'status'=>'required',
        'payed_to'=>'required',
        'income_id'=>'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find Expense
    $Expense = Expense::find($id);

    if (!$Expense) {
        return response()->json(['message' => 'Expense not found'], 404);
    }

    $Expense->receipt_number=$request->receipt_number;
    $Expense->payment_method=$request->payment_method;
    $Expense->description=$request->description;
    $Expense->amount=$request->amount;
    $Expense->date=$request->date;
    $Expense->category_id=$request->category_id;
    $Expense->status=$request->status;
    $Expense->payed_to=$request->payed_to;
    $Expense->income_id=$request->income_id;
    $Expense->save();

    return response()->json(['message' => 'Expense updated successfully']);
}


public function delete(Request $request, $id)
{
    // Validate incoming request
  

    // Find Expense
    $Expense = Expense::find($id);

    if (!$Expense) {
        return response()->json(['message' => 'Expense not found'], 404);
    }

    // Update fields
  
    $Expense->delete();

    return response()->json(['message' => 'Expense Deleted successfully']);
}
}
