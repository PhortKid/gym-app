@extends('workspace_layout.app')


@section('content')
<div class="container">
    <h2 class="mb-4">Sales Report</h2>

    <form method="GET" action="{{ route('sales.report') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <label>From Date</label>
            <input type="date" name="from" value="{{ $from }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>To Date</label>
            <input type="date" name="to" value="{{ $to }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Month</label>
            <select name="month" class="form-select">
                <option value="">-- Select Month --</option>
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>Year</label>
            <select name="year" class="form-select">
                <option value="">-- Select Year --</option>
                @foreach(range(date('Y'), date('Y') - 5) as $y)
                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
       
        <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary btn-sm" type="button" onclick="printContent()">Print</button>
        </div>
    </form>

    <div class="container" id="printable-area">
      <!-- Header -->
      <div class="report-header d-flex justify-content-between align-items-center">
        @include('header')
        <div class="text-end">
          <h5 class="mb-1">Sales Report</h5>
          <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
        </div>
      </div>

   

    <table class="table table-bordered ">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sales as $sale)
            @foreach($sale->items as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>

    <div class="mb-3">
        <strong>Total Revenue:</strong> Tsh {{ number_format($totalRevenue, 2) }}
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
