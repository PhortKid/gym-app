<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function all()
    {
        return response()->json(Attendance::with(['customer'])->get());
    }

    // Add a new user
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Attendance::create([
            'member_id' => $request->member_id,
            'time_in' => Carbon::now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Attendance Added']);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'member_id' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
            'workout_area' => 'nullable',
            'trainer_id' => 'required',
        ]);
    
        // Find the user
        $user = Attendance::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }
       
        // Update fields
        $user->member_id = $request->member_id;
        $user->time_in = $request->time_in ;
        $user->time_out = $request->time_out;
        $user->workout_area = $request->workout_area;
        $user->trainer_id = $request->trainer_id;
        $user->save();
    
        return response()->json(['message' => 'Attendance updated successfully']);
    }
    

    // Delete a user
    public function delete(Request $request, $id)
    {
        // Find the user
        $user = Attendance::find($id);

        if (!$user) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'Attendance deleted successfully']);
    }
}
