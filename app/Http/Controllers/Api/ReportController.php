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

public function incomeSummary(Request $request)
{
    $filter = $request->input('filter', 'daily'); // default daily

    // Define date range based on filter
    if ($filter === 'daily') {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->endOfDay();
    } elseif ($filter === 'monthly') {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    } elseif ($filter === 'yearly') {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();
    } else {
        // default fallback
        $startDate = Carbon::today();
        $endDate = Carbon::today()->endOfDay();
    }

    // Income per category within date range
    $incomeData = IncomeCategory::withSum(['incomes' => function ($query) use ($startDate, $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }], 'amount')->get()->map(function ($cat) {
        return [
            'name' => $cat->name,
            'amount' => $cat->incomes_sum_amount ?? 0,
        ];
    });

    // Customer Income within date range
    $customerIncome = Customer::whereBetween('created_at', [$startDate, $endDate])
        ->sum('payed_amount');

    $totalIncome = $incomeData->sum('amount');
    $grandTotalIncome = $totalIncome + $customerIncome;

    return response()->json([
        'incomeCategories' => $incomeData,
        'customerIncome' => $customerIncome,
        'totalIncome' => $totalIncome,
        'grandTotalIncome' => $grandTotalIncome,
    ]);
}

public function expenseSummary(Request $request)
{
    $filter = $request->input('filter', 'daily');

    if ($filter === 'daily') {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->endOfDay();
    } elseif ($filter === 'monthly') {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    } elseif ($filter === 'yearly') {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();
    } else {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->endOfDay();
    }

    $expenseData = ExpenseCategory::withSum(['expenses' => function ($query) use ($startDate, $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }], 'amount')->get()->map(function ($cat) {
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


