<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Validator;


class MembershipPlanController extends Controller

{
    

    public function all(){
        return response()->json(MembershipPlan::all());
    }

    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'cost' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        MembershipPlan::create(
            [
            'name'=>$request->name,
            'description'=>$request->description,
            'cost'=>$request->cost,
        ]);
        return response()->json(['status'=>'sucess','message'=>'Membership Plan Added']);
      
    }

    public function update(Request $request, $id)
{
    // Validate incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cost' => 'required|numeric|min:0',
    ]);

    // Find membership plan
    $membershipPlan = MembershipPlan::find($id);

    if (!$membershipPlan) {
        return response()->json(['message' => 'Membership Plan not found'], 404);
    }

    // Update fields
    $membershipPlan->name = $request->name;
    $membershipPlan->description = $request->description;
    $membershipPlan->cost = $request->cost;
    $membershipPlan->save();

    return response()->json(['message' => 'Membership Plan updated successfully']);
}


public function delete(Request $request, $id)
{
    // Validate incoming request
  

    // Find membership plan
    $membershipPlan = MembershipPlan::find($id);

    if (!$membershipPlan) {
        return response()->json(['message' => 'Membership Plan not found'], 404);
    }

    // Update fields
  
    $membershipPlan->delete();

    return response()->json(['message' => 'Membership Plan Deleted successfully']);
}

}
