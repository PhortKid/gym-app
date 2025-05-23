@extends('workspace_layout.app')

@section('content')
<div class="container mt-4">
<form method="GET" action="{{ route('income_expense.report') }}" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <select name="filter" class="form-control" required>
                <option value="">-- Select Filter --</option>
                <option value="daily" {{ request('filter') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ request('filter') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ request('filter') == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

    <h3>Income Report</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Income Category</th>
                <th>Amount</th>
                <th>Expected Revenue</th>
                <th>Actual Revenue</th>
            </tr>
        </thead>
        <tbody>
            @php
                $incomeTotal = 0;
            @endphp
            
            @foreach($income_categories as $income_category)
                <tr>
                    <td>{{ $income_category->name }}</td>
                    <td>{{ number_format($income_category->total_amount, 2) }}</td>
                    <td>{{ number_format($expected_incomes[$income_category->id][$expectedField] ?? 0, 2) }}</td>
                    <td>{{ number_format($expected_incomes[$income_category->id][$expectedField] ?? 0-$income_category->total_amount, 2) }}</td>
                </tr>
                @php
                    $incomeTotal += $income_category->total_amount;
                @endphp
            @endforeach
            
            <tr class="table-info">
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($incomeTotal, 2) }}</strong></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <h3>Expense Report</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Expense Category</th>
                <th>Amount</th>
                <th>Projected Expense</th>
                <th>Actual Expense</th>
            </tr>
        </thead>
        <tbody>
            @php
                $expenseTotal = 0;
            @endphp
            
            @foreach($expense_categories as $expense_category)
                <tr>
                    <td>{{ $expense_category->name }}</td>
                    <td>{{ number_format($expense_category->total_amount , 2) }}</td>
                    <td>{{ number_format($projected_expenses[$expense_category->id][$expectedField] ?? 0, 2) }}</td>
                    <td>{{ number_format($projected_expenses[$expense_category->id][$expectedField] ?? 0 - $expense_category->total_amount, 2) }}</td>
                </tr>
                @php
                    $expenseTotal += $expense_category->total_amount ?? 0;
                @endphp
            @endforeach
            
            <tr class="table-info">
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($expenseTotal, 2) }}</strong></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
 
   <h3>Net Profit</h3>
    <table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Category</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        
            <tr>
                <td>Projected Revenue </td>
                <td></td>
            </tr>
       
            <tr>
                <td>Projected Expenses </td>
                <td></td>
            </tr>
            <tr class="table-info" >
                <td>Projected Profit</td>
                <td></td>
            </tr>

            <tr>
                <td>Total Actual Revenue </td>
                <td></td>
            </tr>
           
       
            <tr>
                <td>Total Actual Expenses </td>
                <td></td>
            </tr>


            <tr class="table-info">
                <td>Net Profit/Loss</td>
                <td></td>
            </tr>
            
        </tbody>
        </table>
</div>
@endsection