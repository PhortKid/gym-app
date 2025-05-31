@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Payment Report</h5>
      <div class="d-flex align-items-center gap-2">
        <div id="export-buttons" class="btn-group"></div>
        <button class="btn btn-primary btn-sm" type="button" onclick="printContent()">Print</button>
      </div>
    </div>

    <div class="container mt-3">
      <!-- Filter Dropdown -->
      <div class="mb-3 row">
        <div class="col-md-4">
          <label for="filter-select" class="form-label">Filter by:</label>
          <select id="filter-select" class="form-select">
            <option value="daily">Daily</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
            <option value="custom">By Month & Year</option>
          </select>
        </div>

        <div class="col-md-4">
          <label for="month-select" class="form-label">Month:</label>
          <select id="month-select" class="form-select">
            @for ($m = 1; $m <= 12; $m++)
              <option value="{{ $m }}">{{ date("F", mktime(0, 0, 0, $m, 1)) }}</option>
            @endfor
          </select>
        </div>

        <div class="col-md-4">
          <label for="year-select" class="form-label">Year:</label>
          <select id="year-select" class="form-select">
            @for ($y = now()->year; $y >= 2010; $y--)
              <option value="{{ $y }}">{{ $y }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>

    <div class="container" id="printable-area">
      <div class="report-header d-flex justify-content-between align-items-center">
        @include('header')
        <div class="text-end">
          <h5 class="mb-1">Attendance Report</h5>
          <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
        </div>
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>Payment Type</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody id="customer-list" class="table-border-bottom-0">
            <!-- Rows inserted dynamically here -->
          </tbody>
          <tfoot>
            <tr>
              <td><strong>Total</strong></td>
              <td><strong id="total-amount">0.00 TZS</strong></td>
            </tr>
          </tfoot>

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
    var printArea = document.getElementById('printable-area').innerHTML;
    var originalContent = document.body.innerHTML;
    document.body.innerHTML = printArea;
    window.print();
    document.body.innerHTML = originalContent;
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterSelect = document.getElementById('filter-select');
    const monthSelect = document.getElementById('month-select');
    const yearSelect = document.getElementById('year-select');

    function fetchPayments(filter = 'daily') {
      const month = monthSelect.value;
      const year = yearSelect.value;

      let url = `/api/payment_report?filter=${filter}`;
      if (filter === 'custom') {
        url += `&month=${month}&year=${year}`;
      }

      fetch(url)
        .then(response => response.json())
        .then(data => {
          const customerList = document.getElementById('customer-list');
          customerList.innerHTML = '';

          let totalAmount = 0;

          data.forEach(payment => {
            const row = document.createElement('tr');
            const amount = parseFloat(payment.total);
            totalAmount += amount;

            row.innerHTML = `
              <td>${payment.payment_method}</td>
              <td>${amount.toFixed(2)} TZS</td>
            `;
            customerList.appendChild(row);
          });

          // Update total
          document.getElementById('total-amount').innerText = `${totalAmount.toFixed(2)} TZS`;
        })
        .catch((error) => {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: `Error fetching payment data`,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'z-top' }
          });
        });
    }

    // Event listeners
    filterSelect.addEventListener('change', () => {
      fetchPayments(filterSelect.value);
    });

    monthSelect.addEventListener('change', () => {
      if (filterSelect.value === 'custom') fetchPayments('custom');
    });

    yearSelect.addEventListener('change', () => {
      if (filterSelect.value === 'custom') fetchPayments('custom');
    });

    // Initial load
    fetchPayments();
  });
</script>
@endsection
