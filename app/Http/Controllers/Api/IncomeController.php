<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    
    public function all(){
        return response()->json(Income::all());
    }

    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'nullable',
            'date'=> 'required',
            'category_id'=> 'required',
            'payment_type'=> 'required',
          
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Income::create(
            [
                'amount' => $request->amount,
                'description' =>$request->description,
                'date'=> $request->date,
                'category_id'=>$request->category_id,
                'payment_type'=> $request->payment_type,
        ]);
        return response()->json(['status'=>'sucess','message'=>'Income Added']);
      
    }

    public function update(Request $request, $id)
{
    /* Validate incoming request
    $request->validate([
        'amount' => 'required',
        'description' => 'nullable',
        'date'=> 'required',
        'category_id'=> 'required',
        'payment_type'=> 'required',
       
    ]);
*/
    // Find Income
    $Income = Income::find($id);

    if (!$Income) {
        return response()->json(['message' => 'Income not found'], 404);
    }

    // Update fields
   
    $Income->amount = $request->amount;
    $Income->description =$request->description;
    $Income->date=$request->date;
    $Income->category_id=$request->category_id;
    $Income->payment_type= $request->payment_type;
    $Income->save();

    return response()->json(['message' => 'Income updated successfully']);
}


public function delete(Request $request, $id)
{
    // Validate incoming request
  

    // Find Income
    $Income = Income::find($id);

    if (!$Income) {
        return response()->json(['message' => 'Income not found'], 404);
    }

    // Update fields
  
    $Income->delete();

    return response()->json(['message' => 'Income Deleted successfully']);
}
}
