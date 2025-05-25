@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Expense Report (With Income Source)</h5>
      <select id="filter-select" class="form-select" style="width: 150px;">
        <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Daily</option>
        <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Monthly</option>
        <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>Yearly</option>
      </select>
      <button class="btn btn-success" onclick="printContent()">Print Report</button>
    </div>

    <div class="card-body printableeee" id="printable-area">
            <!-- Header Section -->
            <div class="report-header d-flex justify-content-between align-items-center mb-4">
              @include('header')
                <div class="text-end">
                    <h5 class="mb-1">Expenses Report</h5>
                    <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                </div>
            </div>

    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Expense Category</th>
            <th>Amount (TZS)</th>
            <th>Spent From (Income Source)</th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach($expenses as $row)
            <tr>
              <td>{{ $row['expense_category'] }}</td>
              <td>{{ number_format($row['total'], 2) }}</td>
              <td>{{ $row['income_category'] }}</td>
              @php $total += $row['total']; @endphp
            </tr>
          @endforeach
          <tr>
            <th>Total</th>
            <th>{{ number_format($total, 2) }} TZS</th>
            <th></th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

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

<script>
  document.getElementById('filter-select').addEventListener('change', function () {
    const filter = this.value;
    window.location.href = `?filter=${filter}`;
  });
</script>
@endsection
