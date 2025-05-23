<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ExpectedIncome;
use App\Models\ProjectedExpense;

class ReportController extends Controller
{
 

    public function income_expense(Request $request)
    {
        $filter = $request->input('filter');
        $date = $request->input('date') ?? now()->toDateString();
    
        $incomeQuery = DB::table('income_category')
            ->leftJoin('income', 'income_category.id', '=', 'income.category_id');
    
        $expenseQuery = DB::table('expense_categories')
            ->leftJoin('expenses', 'expense_categories.id', '=', 'expenses.category_id');
    
        if ($filter === 'daily') {
            $incomeQuery->whereDate('income.date', $date);
            $expenseQuery->whereDate('expenses.date', $date);
            $expectedField = 'daily';
        } elseif ($filter === 'monthly') {
            $incomeQuery->whereMonth('income.date', date('m', strtotime($date)))
                        ->whereYear('income.date', date('Y', strtotime($date)));
            $expenseQuery->whereMonth('expenses.date', date('m', strtotime($date)))
                         ->whereYear('expenses.date', date('Y', strtotime($date)));
            $expectedField = 'monthly';
        } elseif ($filter === 'yearly') {
            $incomeQuery->whereYear('income.date', date('Y', strtotime($date)));
            $expenseQuery->whereYear('expenses.date', date('Y', strtotime($date)));
            $expectedField = 'annual';
        } else {
            $expectedField = 'monthly'; // default fallback
        }
    
        $income_categories = $incomeQuery
            ->select('income_category.id', 'income_category.name', DB::raw('SUM(income.amount) as total_amount'))
            ->groupBy('income_category.id', 'income_category.name')
            ->get();
    
        $expense_categories = $expenseQuery
            ->select('expense_categories.id', 'expense_categories.name', DB::raw('SUM(expenses.amount) as total_amount'))
            ->groupBy('expense_categories.id', 'expense_categories.name')
            ->get();
    
        // Fetch expected income & projected expenses
        $expected_incomes_raw = \App\Models\ExpectedIncome::all();
        $expected_incomes = [];
        foreach ($expected_incomes_raw as $ei) {
            $expected_incomes[$ei->income_id] = [
                'daily' => $ei->daily,
                'monthly' => $ei->monthly,
                'annual' => $ei->annual,
            ];
        }
    
        $projected_expenses_raw = \App\Models\ProjectedExpense::all();
        $projected_expenses = [];
        foreach ($projected_expenses_raw as $pe) {
            $projected_expenses[$pe->expense_id] = [
                'daily' => $pe->daily,
                'monthly' => $pe->monthly,
                'annual' => $pe->annual,
            ];
        }
    
        // Total actuals
        $incomeTotal = $income_categories->sum('total_amount');
        $expenseTotal = $expense_categories->sum('total_amount');
    
        // Expected totals
        $expectedRevenueTotal = collect($expected_incomes)->sum($expectedField);
        $projectedExpenseTotal = collect($projected_expenses)->sum($expectedField);
    
        $projectedProfit = $expectedRevenueTotal - $projectedExpenseTotal;
        $netProfit = $incomeTotal - $expenseTotal;
    
        return view('workspace.reports.income_expense', compact(
            'income_categories',
            'expense_categories',
            'expected_incomes',
            'projected_expenses',
            'expectedField',
            'incomeTotal',
            'expenseTotal',
            'expectedRevenueTotal',
            'projectedExpenseTotal',
            'projectedProfit',
            'netProfit'
        ));
    }

}
