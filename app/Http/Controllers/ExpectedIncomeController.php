<?php

namespace App\Http\Controllers;

use App\Models\ExpectedIncome;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class ExpectedIncomeController extends Controller
{
    
    public function index()
    {
        $income_categories=IncomeCategory::all();
        $expectedIncomes = ExpectedIncome::with('incomecategory')->get();
        return view('workspace.expected_income.index',compact('expectedIncomes','income_categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'daily' => 'nullable|numeric',
            'monthly' => 'nullable|numeric',
            'annual' => 'nullable|numeric',
            'income_id' => 'required',
        ]); 
    
        $expectedIncome = new ExpectedIncome();
        $expectedIncome->fill($request->only(['daily', 'monthly', 'annual','income_id']));
        $expectedIncome->save();
    
        return redirect('/expected_incomes');
    }
    
    public function update(Request $request, $id)
    {
        $expectedIncome = ExpectedIncome::findOrFail($id);

        $request->validate([
            'daily' => 'nullable|numeric',
            'monthly' => 'nullable|numeric',
            'annual' => 'nullable|numeric',
           
        ]);

        $expectedIncome->update($request->only(['daily', 'monthly', 'annual']));

        return redirect('/expected_incomes');
    }


    public function destroy($id)
    {
        $expectedIncome = ExpectedIncome::findOrFail($id);
        $expectedIncome->delete();

        return redirect('/expected_incomes');
    }
}
