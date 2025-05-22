<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\Customer;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function incomeSummary()
    {
        // Income per category
        $incomeData = IncomeCategory::withSum('incomes', 'amount')->get()->map(function ($cat) {
            return [
                'name' => $cat->name,
                'amount' => $cat->incomes_sum_amount ?? 0,
            ];
        });

        // Customer Income
        $customerIncome = Customer::sum('payed_amount');

        // Total from income categories only
        $totalIncome = $incomeData->sum('amount');

        // Grand total (including customer income)
        $grandTotalIncome = $totalIncome + $customerIncome;

        return response()->json([
            'incomeCategories' => $incomeData,
            'customerIncome' => $customerIncome,
            'totalIncome' => $totalIncome,
            'grandTotalIncome' => $grandTotalIncome,
        ]);
    }

    public function expenseSummary()
    {
        // Expense per category
        $expenseData = ExpenseCategory::withSum('expenses', 'amount')->get()->map(function ($cat) {
            return [
                'name' => $cat->name,
                'amount' => $cat->expenses_sum_amount ?? 0,
            ];
        });

        $totalExpenses = $expenseData->sum('amount');

        return response()->json([
            'expenseCategories' => $expenseData,
            'totalExpenses' => $totalExpenses,
        ]);
    }

}


