<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ExpenseCategory;
use App\Models\Expense;


class ExpenseReportController extends Controller
{

    public function show(Request $request)
    {
        $filter = $request->get('filter', 'daily');

        $query = Expense::with(['category', 'incomeCategory']);
    
        if ($filter === 'daily') {
            $query->whereDate('date', Carbon::today());
        } elseif ($filter === 'monthly') {
            $query->whereMonth('date', Carbon::now()->month)
                  ->whereYear('date', Carbon::now()->year);
        } elseif ($filter === 'yearly') {
            $query->whereYear('date', Carbon::now()->year);
        }
    
        $expenses = $query->get()
            ->groupBy(fn($item) => $item->category_id . '-' . $item->income_id)
            ->map(function ($group) {
                $first = $group->first();
                return [
                    'expense_category' => optional($first->category)->name ?? 'Unknown',
                    'income_category' => optional($first->incomeCategory)->name ?? 'Unknown',
                    'total' => $group->sum('amount'),
                ];
            })->values();
    
        return view('workspace.reports.expense', compact('expenses', 'filter'));
    
        
    }

}