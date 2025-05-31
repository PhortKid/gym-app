<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ExpectedIncome;
use App\Models\ProjectedExpense;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Product;


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



    public function financialSummary()
{
      // All income categories with their incomes
      $incomeCategories = IncomeCategory::with('incomes')->get();

      // All expense categories with their expenses
      $expenseCategories = ExpenseCategory::with('expenses')->get();
  
      // Total expected income (sum of all incomes)
      $totalIncome = $incomeCategories->flatMap->incomes->sum('amount');
  
      // Total expenses
      $totalExpenses = $expenseCategories->flatMap->expenses->sum('amount');
  
      // Current month range
      $startOfMonth = Carbon::now()->startOfMonth();
      $endOfMonth = Carbon::now()->endOfMonth();
  
      // CURRENT DEBTS: Customers with start_date in current month and not fully paid
      $currentDebts = Customer::whereBetween('start_date', [$startOfMonth, $endOfMonth])
          ->whereColumn('amount', '>', 'payed_amount')
          ->get()
          ->sum(function ($customer) {
              return $customer->amount - $customer->payed_amount;
          });
  
      // PREVIOUS DEBTS: Customers before current month with unpaid balances
      $previousDebts = Customer::where('start_date', '<', $startOfMonth)
          ->whereColumn('amount', '>', 'payed_amount')
          ->get()
          ->sum(function ($customer) {
              return $customer->amount - $customer->payed_amount;
          });
  
    
  
      // Net Position = Income - Expenses
      $netPosition = $totalIncome - $totalExpenses;
  
      return view('workspace.reports.financial_summary', [
          'incomeCategories' => $incomeCategories,
          'expenseCategories' => $expenseCategories,
          'totalIncome' => $totalIncome,
          'totalExpenses' => $totalExpenses,
          'currentDebts' => $currentDebts,
          'previousDebts' => $previousDebts,
         
          'netPosition' => $netPosition,
      ]);


}


        public function productReport()
        {
            $products = Product::with('saleItems')->get();

            $report = $products->map(function ($product) {
                $totalSold = $product->saleItems->sum('quantity');
                $totalRevenue = $product->saleItems->sum('total'); // or 'quantity * price'

                return [
                    'name' => $product->name,
                    'stock_quantity' => $product->stock_quantity,
                    'min_stock_level' => $product->min_stock_level,
                    'total_sold' => $totalSold,
                    'total_revenue' => $totalRevenue,
                ];
            });

            return view('workspace.reports.product-report', compact('report'));
        }

}
