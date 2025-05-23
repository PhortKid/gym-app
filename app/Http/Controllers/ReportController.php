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
    $filter = $request->input('filter', 'daily');
    $date = $request->input('date') ? Carbon::parse($request->input('date')) : now();

    // Select income
    $incomeQuery = DB::table('income_category')
        ->leftJoin('income', 'income_category.id', '=', 'income.category_id');

    // Select expense
    $expenseQuery = DB::table('expense_categories')
        ->leftJoin('expenses', 'expense_categories.id', '=', 'expenses.category_id');

    if ($filter === 'daily') {
        $incomeQuery->whereDate('income.date', $date->toDateString());
        $expenseQuery->whereDate('expenses.date', $date->toDateString());
    } elseif ($filter === 'monthly') {
        $incomeQuery->whereYear('income.date', $date->year)->whereMonth('income.date', $date->month);
        $expenseQuery->whereYear('expenses.date', $date->year)->whereMonth('expenses.date', $date->month);
    } elseif ($filter === 'yearly') {
        $incomeQuery->whereYear('income.date', $date->year);
        $expenseQuery->whereYear('expenses.date', $date->year);
    }

    $income_categories = $incomeQuery
        ->select('income_category.id', 'income_category.name', DB::raw('SUM(income.amount) as total_amount'))
        ->groupBy('income_category.id', 'income_category.name')
        ->get();

    $expense_categories = $expenseQuery
        ->select('expense_categories.id', 'expense_categories.name', DB::raw('SUM(expenses.amount) as total_amount'))
        ->groupBy('expense_categories.id', 'expense_categories.name')
        ->get();

    // Expected income by category
    $expected_incomes = ExpectedIncome::all()->keyBy('income_id');
    // Projected expenses by category
    $projected_expenses = ProjectedExpense::all()->keyBy('expense_id');

    // Define field to fetch (daily, monthly, annual)
    $expectedField = match ($filter) {
        'daily' => 'daily',
        'monthly' => 'monthly',
        'yearly' => 'annual',
        default => 'daily'
    };

    return view('workspace.reports.income_expense', compact(
        'income_categories',
        'expense_categories',
        'expected_incomes',
        'projected_expenses',
        'expectedField'
    ));
}

}
