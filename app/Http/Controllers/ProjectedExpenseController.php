<?php

namespace App\Http\Controllers;

use App\Models\ProjectedExpense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ProjectedExpenseController extends Controller
{
    
    public function index()
    {
        $expense_types=ExpenseCategory::all();
        $projected_expenses = ProjectedExpense::with('expensetype')->get();
        return view('workspace.projected_expense.index',compact('projected_expenses','expense_types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'daily' => 'nullable|numeric',
            'monthly' => 'nullable|numeric',
            'annual' => 'nullable|numeric',
            'expense_id' => 'required',
        ]); 
    
        $projected_expense = new ProjectedExpense();
        $projected_expense->fill($request->only(['daily', 'monthly', 'annual','expense_id']));
        $projected_expense->save();
    
        return redirect('/projected_expenses');
    }
    
    public function update(Request $request, $id)
    {
        $projected_expense = ProjectedExpense::findOrFail($id);

        $request->validate([
            'daily' => 'nullable|numeric',
            'monthly' => 'nullable|numeric',
            'annual' => 'nullable|numeric',
           
        ]);

        $projected_expense->update($request->only(['daily', 'monthly', 'annual']));

        return redirect('/projected_expenses');
    }


    public function destroy($id)
    {
        $projected_expense = ProjectedExpense::findOrFail($id);
        $projected_expense->delete();

        return redirect('/projected_expenses');
    }
}
