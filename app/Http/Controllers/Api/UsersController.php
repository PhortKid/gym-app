<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // Fetch all users
    public function all()
    {
        return response()->json(User::all());
    }

    public function trainer()
    {
        return response()->json(User::where('position','Trainer')->get());
    }

    // Add a new user
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
          //  'role' => 'required|string|max:50',
            'specialization' => 'nullable|string|max:255',
         //   'salary' => 'nullable|numeric|min:0',
          //  'work_schedule' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:20',
            'position' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            //'role' => $request->role,
            'specialization' => $request->specialization,
           // 'salary' => $request->salary,
          //  'work_schedule' => $request->work_schedule,
            'phone_number' => $request->phone_number,
            'position' => $request->position,
        ]);

        return response()->json(['status' => 'success', 'message' => 'User Added']);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8',
            'specialization' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:20',
            'position' => 'nullable|string|max:100',
        ]);
    
        // Find the user
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        // Update fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->specialization = $request->specialization;
        $user->phone_number = $request->phone_number;
        $user->position = $request->position;
        $user->save();
    
        return response()->json(['message' => 'User updated successfully']);
    }
    

    // Delete a user
    public function delete(Request $request, $id)
    {
        // Find the user
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
