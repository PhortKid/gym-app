@extends('workspace_layout.app')

@section('content')
<div class="container mt-5">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Income Report</h5>
      <div class="d-flex align-items-center gap-2">
        <form method="GET" action="{{ route('income.report') }}">
          <select name="filter" onchange="this.form.submit()" class="form-select form-select-sm" style="width: auto;">
            <option value="daily" {{ $filter === 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="yearly" {{ $filter === 'yearly' ? 'selected' : '' }}>Yearly</option>
          </select>
        </form>
        <button class="btn btn-primary btn-sm" onclick="printContent()">Print</button>
      </div>
    </div>

    <div class="container" id="printable-area">
      <div class="report-header d-flex justify-content-between align-items-center mt-3">
      @include('header')
        <div class="text-end">
          <h5 class="mb-1">Income Report</h5>
          <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
        </div>
      </div>

      <table class="table table-striped mt-4">
        <thead>
          <tr>
            <th>Category</th>
            <th>Total Income</th>
            <th>Total Spent</th>
            <th>Balance</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($report as $row)
            <tr>
              <td>{{ $row['category'] }}</td>
              <td>{{ number_format($row['total_income'], 2) }} TZS</td>
              <td>{{ number_format($row['total_spent'], 2) }} TZS</td>
              <td>{{ number_format($row['balance'], 2) }} TZS</td>
            </tr>
          @empty
            <tr>
              <td colspan="4">No data available for selected period.</td>
            </tr>
          @endforelse
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
    </div>
  </div>
</div>

<script>
  function printContent() {
    const printArea = document.getElementById('printable-area').innerHTML;
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = printArea;
    window.print();
    document.body.innerHTML = originalContent;
  }
</script>
@endsection
