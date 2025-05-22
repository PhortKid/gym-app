@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
   
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Payment Report</h5>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Button Container -->
    <div id="export-buttons" class="btn-group">
     
    </div>
    <button class="btn btn-primary btn-sm" type="button"   onclick="printContent()">
      Print
    </button>

    
  </div>
</div>

<div class="container" id="printable-area">
                                   <!-- Header -->
                                    <div class="report-header d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('favicon.png') }}" alt="Company Logo" class="company-logo me-3">
                                            <div>
                                                <h3 class="mb-1">AMAZING FITNESS GYM</h3>
                                                <p class="mb-0">Fitness & Wellness Center</p>
                                                <p class="mb-0">Email: info@gymfitsolutions.com | Phone: +255 712 345 678</p>
                                                <p class="mb-0">Address:Mshindo, Iringa, Tanzania</p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <h5 class="mb-1">Attendance Report</h5>
                                            <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                                        </div>
                                    </div>
      <table  class="table table-striped">
        <thead>
          <tr>
            <th>Payment Type</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody id="customer-list" class="table-border-bottom-0">
          <!-- Rows will be inserted here dynamically -->
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


  // Function to fetch and display customer data
  document.addEventListener('DOMContentLoaded', function() {
    fetchPayments();
  });

  function fetchPayments() {
  fetch('http://127.0.0.1:8000/api/payment_report')
    .then(response => response.json())
    .then(data => {
      const customerList = document.getElementById('customer-list');
      customerList.innerHTML = ''; 

      data.forEach(payment => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${payment.payment_method}</td>
          <td>${parseFloat(payment.total).toFixed(2)} TZS</td>
          
        `;
        customerList.appendChild(row);
      });

      // Initialize DataTable
      $('#customer-table').DataTable();
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
        customClass: {
          popup: 'z-top'
        }
      });
    });
}



</script>

@endsection
