<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
    
    public function all(){
        return response()->json(ExpenseCategory::all());
    }

    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
          
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        ExpenseCategory::create(
            [
            'name'=>$request->name,
        ]);
        return response()->json(['status'=>'sucess','message'=>'Expense Category Added']);
      
    }

    public function update(Request $request, $id)
{
    // Validate incoming request
    $request->validate([
        'name' => 'required|string|max:255',
       
    ]);

    // Find Expense Category
    $ExpenseCategory = ExpenseCategory::find($id);

    if (!$ExpenseCategory) {
        return response()->json(['message' => 'Expense Category not found'], 404);
    }

    // Update fields
    $ExpenseCategory->name = $request->name;
    $ExpenseCategory->save();

    return response()->json(['message' => 'Expense Category updated successfully']);
}


public function delete(Request $request, $id)
{
    // Validate incoming request
  

    // Find Expense Category
    $ExpenseCategory = ExpenseCategory::find($id);

    if (!$ExpenseCategory) {
        return response()->json(['message' => 'Expense Category not found'], 404);
    }

    // Update fields
  
    $ExpenseCategory->delete();

    return response()->json(['message' => 'Expense Category Deleted successfully']);
}
}
