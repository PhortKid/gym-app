@extends('workspace_layout.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Financial Summary Report</h4>

    <table class="table table-bordered" id="financial-summary">
        <thead class="table-dark">
            <tr>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Amount (TZS)</th>
            </tr>
        </thead>

        <tbody>
            {{-- INCOME SECTION --}}
            <tr>
                <td rowspan="{{ count($incomeCategories) + 1 }}"><strong>Income</strong></td>
            </tr>
            @foreach($incomeCategories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ number_format($category->incomes->sum('amount')) }}</td>
                </tr>
            @endforeach

            {{-- EXPENSE SECTION --}}
            <tr>
                <td rowspan="{{ count($expenseCategories) + 1 }}"><strong>Expense</strong></td>
            </tr>
            @foreach($expenseCategories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ number_format($category->expenses->sum('amount')) }}</td>
                </tr>
            @endforeach
        </tbody>

        {{-- SUMMARY ROWS --}}
        <tbody>
            <tr class="table-success">
                <td colspan="2"><strong>Total Expected Income</strong></td>
                <td class="text-primary"><strong>TZS {{ number_format($totalIncome) }}</strong></td>
            </tr>

            <tr class="table-success">
                <td colspan="2"><strong>Current Debts</strong></td>
                <td class="text-success"><strong>TZS {{ number_format($currentDebts) }}</strong></td>
            </tr>

            <tr class="table-success">
                <td colspan="2"><strong>Previous Debts</strong></td>
                <td class="text-success"><strong>TZS {{ number_format($previousDebts) }}</strong></td>
            </tr>

        
            <tr class="table-danger">
                <td colspan="2"><strong>Total Expenditures</strong></td>
                <td class="text-danger"><strong>TZS {{ number_format($totalExpenses) }}</strong></td>
            </tr>

            <tr class="table-info">
                <td colspan="2"><strong>Net Position</strong></td>
                <td><strong>TZS {{ number_format($netPosition) }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
