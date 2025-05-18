@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.customer_management.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Payment Report</h5>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Button Container -->
    <div id="export-buttons" class="btn-group">
     
    </div>

    
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
  </div>
</div>



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
