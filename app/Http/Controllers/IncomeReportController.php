<?php
namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class IncomeReportController extends Controller
{

    public function show(Request $request)
    {
        $filter = $request->input('filter', 'daily');
    
        $categories = IncomeCategory::with(['incomes', 'expenses'])->get();
    
        $report = $categories->map(function ($category) use ($filter) {
            $incomes = $category->incomes;
            $expenses = $category->expenses;
    
            if ($filter === 'daily') {
                $incomes = $incomes->where('date', Carbon::today());
                $expenses = $expenses->where('date', Carbon::today());
            } elseif ($filter === 'monthly') {
                $incomes = $incomes->whereBetween('date', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
                $expenses = $expenses->whereBetween('date', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
            } elseif ($filter === 'yearly') {
                $incomes = $incomes->whereBetween('date', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ]);
                $expenses = $expenses->whereBetween('date', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear()
                ]);
            }
    
            $total_income = $incomes->sum('amount');
            $total_spent = $expenses->sum('amount');
    
            return [
                'category' => $category->name,
                'total_income' => $total_income,
                'total_spent' => $total_spent,
                'balance' => $total_income - $total_spent,
            ];
        });
    
        return view('workspace.reports.income', compact('report', 'filter'));
    }


}