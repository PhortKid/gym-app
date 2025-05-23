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
            <button class="btn btn-primary " onclick="printContent()">Print</button>
        </div>
        
        

        

    </div>
</form>


<div class="container" id="printable-area">
      <!-- Header -->
      <div class="report-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="{{ asset('favicon.png') }}" alt="Company Logo" class="company-logo me-3">
          <div>
            <h3 class="mb-1">AMAZING FITNESS GYM</h3>
            <p class="mb-0">Fitness & Wellness Center</p>
            <p class="mb-0">Email: info@gymfitsolutions.com | Phone: </p>
            <p class="mb-0">Address:Mshindo, Iringa, Tanzania</p>
          </div>
        </div>
        <div class="text-end">
          <h5 class="mb-1">Income vs Expense Report</h5>
          <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
        </div>
      </div>

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
                    <td>{{ number_format($expected_incomes[$income_category->id][$expectedField]-$income_category->total_amount, 2) }}</td>
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
                    <td>{{ number_format($projected_expenses[$expense_category->id][$expectedField]  - $expense_category->total_amount, 2) }}</td>
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
    <td>Projected Revenue</td>
    <td>{{ number_format($expectedRevenueTotal, 2) }}</td>
</tr>
<tr>
    <td>Projected Expenses</td>
    <td>{{ number_format($projectedExpenseTotal, 2) }}</td>
</tr>
<tr class="table-info">
    <td>Projected Profit</td>
    <td>{{ number_format($projectedProfit, 2) }}</td>
</tr>
<tr>
    <td>Total Actual Revenue</td>
    <td>{{ number_format($incomeTotal, 2) }}</td>
</tr>
<tr>
    <td>Total Actual Expenses</td>
    <td>{{ number_format($expenseTotal, 2) }}</td>
</tr>
<tr class="table-info">
    <td>Net Profit/Loss</td>
    <td>{{ number_format($netProfit, 2) }}</td>
</tr>

            
        </tbody>
        </table>

        <div class="row mt-5">
        <div class="col-md-6">
          <p><strong>Prepared By:</strong> Director Of Operation</p>
        </div>
        <div class="col-md-6 text-end">
          <p><strong>Signature:</strong> __________________________</p>
        </div>
      </div>
    </div><!-- printable area -->


</div>


<script>
  function printContent() {
    var printArea = document.getElementById('printable-area').innerHTML;
    var originalContent = document.body.innerHTML;
    document.body.innerHTML = printArea;
    window.print();
    document.body.innerHTML = originalContent;
  }
</script>
@endsection