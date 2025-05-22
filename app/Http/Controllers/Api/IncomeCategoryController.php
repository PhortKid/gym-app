<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Validator;

class IncomeCategoryController extends Controller
{
    
    public function all(){
        return response()->json(IncomeCategory::all());
    }

    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
          
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        IncomeCategory::create(
            [
            'name'=>$request->name,
        ]);
        return response()->json(['status'=>'sucess','message'=>'Income Category Added']);
      
    }

    public function update(Request $request, $id)
{
    // Validate incoming request
    $request->validate([
        'name' => 'required|string|max:255',
       
    ]);

    // Find Income Category
    $IncomeCategory = IncomeCategory::find($id);

    if (!$IncomeCategory) {
        return response()->json(['message' => 'Income Category not found'], 404);
    }

    // Update fields
    $IncomeCategory->name = $request->name;
    $IncomeCategory->save();

    return response()->json(['message' => 'Income Category updated successfully']);
}


public function delete(Request $request, $id)
{
    // Validate incoming request
  

    // Find Income Category
    $IncomeCategory = IncomeCategory::find($id);

    if (!$IncomeCategory) {
        return response()->json(['message' => 'Income Category not found'], 404);
    }

    // Update fields
  
    $IncomeCategory->delete();

    return response()->json(['message' => 'Income Category Deleted successfully']);
}
}
