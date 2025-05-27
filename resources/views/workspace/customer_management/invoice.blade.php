@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.customer_management.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Invoice</h5>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Button Container -->
    <div id="export-buttons" class="btn-group">
     
    </div>

   
  </div>
</div>

    <div class="table-responsive text-nowrap">
      <table id="customer-table" class="table table-striped">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Start Date</th>
            <th>Expire Date</th>
            <th>Payment Plan</th>
            <th>Membership Type</th>
            <th>Payment Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="customer-list" class="table-border-bottom-0">
          <!-- Rows will be inserted here dynamically -->
        </tbody>
      </table>
    </div>
  </div>
</div>


<!--<button class="btn btn-success" onclick="printContent()">Print Report</button>-->

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
    fetchCustomers();
  });

  function fetchCustomers() {
    fetch('/api/invoice')
      .then(response => response.json())
      .then(data => {
        const customerList = document.getElementById('customer-list');
        customerList.innerHTML = ''; 

        data.forEach(customer => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${customer.full_name}</span></td>
            <td>${customer.start_date}</td>
            <td>${customer.expiry_date ? customer.expiry_date : customer.start_date}</td>
            <td>${customer.payment_plan}</td>
            <td>${customer.membership_type ? customer.membership_type.name : 'N/A'}</td>
            <td>
              ${
                customer.paid_amount >= customer.amount 
                  ? (customer.paid_amount > customer.amount 
                      ? 'Exceed' 
                      : 'Paid')
                  : (customer.paid_amount >= 1 
                      ? 'Partial Paid' 
                      : 'Not Paid')
              }
            </td>
            <td>


            <div class="d-flex align-items-center">
            <a href="#" class="text-info me-3" data-bs-toggle="modal" data-bs-target="#viewCustomer${customer.id}">
              <i class="bx bx-show me-1"></i> View
            </a>
          
          </div>

            </td>
                  <!-- View Customer Modal -->
                          <div class="modal fade" id="viewCustomer${customer.id}" tabindex="-1" aria-hidden="true">
                          
                            <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel4">View Invoice</h5>
                                  <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body" >
                                 <div class="for printing" id="printable-area">
                                  <!-- Header -->
                            <div class="report-header d-flex justify-content-between align-items-center">
                            @include('header')
                              <div class="text-end">
                                <h5 class="mb-1">Invoice</h5>
                                <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-md-4"><strong>Full Name:</strong> ${customer.full_name}</div>
                              <div class="col-md-4"><strong>Email:</strong> ${customer.email}</div>
                              <div class="col-md-4"><strong>Phone:</strong> ${customer.phone_number}</div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-md-4"><strong>Start Date:</strong> ${customer.start_date}</div>
                              <div class="col-md-4"><strong>Expiry Date:</strong> ${customer.expiry_date}</div>
                              <div class="col-md-4"><strong>Gender:</strong> ${customer.gender}</div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-md-4"><strong>Amount:</strong> ${customer.amount} TZS</div>
                              <div class="col-md-4"><strong>Paid:</strong> ${customer.paid_amount} TZS</div>
                              <div class="col-md-4"><strong>Remaining:</strong> ${customer.amount - customer.paid_amount} TZS</div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-md-4"><strong>Plan:</strong> ${customer.payment_plan}</div>
                              <div class="col-md-4"><strong>Trainer:</strong> ${customer.assigned_trainer?.name || 'N/A'}</div>
                              <div class="col-md-4"><strong>Membership:</strong> ${customer.membership_type?.name || 'N/A'}</div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-md-12">
                                <strong>Health Notes:</strong>
                                <div class="border rounded p-2">${customer.health_notes || 'N/A'}</div>
                              </div>
                            </div>

                                  
                                 </div><!-- printable area -->

                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Close
                                  </button>
                                 <button type="button" class="btn btn-primary" onclick="printContent()">Print</button>
                                </div>
                              </div>
                            </div>
                          </div>
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
          title: `Error fetching Member  data `,
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'z-top'
          }
        });
      });
  }

//fetch trainer

function fetchTrainers() {
  fetch("/api/users") 
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      const trainerSelect = document.getElementById('assigned_trainer_id');
      trainerSelect.innerHTML = '<option value="">-- Select Trainer --</option>'; 

      data.forEach(user => {
        if (user.position === 'Trainer') {
          const option = document.createElement('option');
          option.value = user.id;
          option.textContent = user.name;
          trainerSelect.appendChild(option);
        }
      });
    })
    .catch(error => {
      console.error('Error fetching trainers:', error);
    });
}

// Call this function when the page loads or when the modal opens
document.addEventListener('DOMContentLoaded', fetchTrainers);




</script>

@endsection
