@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.customer_management.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Paid Members</h5>
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



<script>

  // Function to fetch and display customer data
  document.addEventListener('DOMContentLoaded', function() {
    fetchCustomers();
  });

  function fetchCustomers() {
    fetch('/api/paid_customer')
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
            </a> |
            <a href="/receipt/${customer.card_number}" class="text-info me-3" 
              <i class="bx bx-show me-1"></i>Receipt
            </a>
          </div>

            </td>
                  <!-- View Customer Modal -->
                          <div class="modal fade" id="viewCustomer${customer.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel4">Paid Member</h5>
                                  <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   <div class="for printing" id="printable-area">
                                  <!-- Header -->
                            <div class="report-header d-flex justify-content-between align-items-center">
                               @include('header')
                              <div class="text-end">
                                <h5 class="mb-1">Paid Member</h5>
                                <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                              </div>
                            </div>

                            <div class="container-fluid">
                              <div class="row mb-3">
                                <div class="col-md-4">
                                  <strong>Full Name:</strong>
                                  <div>${customer.full_name}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Email:</strong>
                                  <div>${customer.email}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Gender:</strong>
                                  <div>${customer.gender}</div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-4">
                                  <strong>Phone Number:</strong>
                                  <div>${customer.phone_number}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Nationality:</strong>
                                  <div>${customer.nationality}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Start Date:</strong>
                                  <div>${customer.start_date}</div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-4">
                                  <strong>Expiry Date:</strong>
                                  <div>${customer.expiry_date}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Next of Kin Name:</strong>
                                  <div>${customer.next_of_kin_name}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Next of Kin Relation:</strong>
                                  <div>${customer.next_of_kin_relation}</div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-4">
                                  <strong>Next of Kin Phone:</strong>
                                  <div>${customer.next_of_kin_phone}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Payment Plan:</strong>
                                  <div>${customer.payment_plan}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Preferred Workout Time:</strong>
                                  <div>${customer.preferred_workout_time}</div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-4">
                                  <strong>Amount:</strong>
                                  <div>${customer.amount} TZS</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Paid Amount:</strong>
                                  <div>${customer.paid_amount} TZS</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Remain Amount:</strong>
                                  <div>${customer.amount-customer.paid_amount} TZS</div>
                                </div>
                              </div>

                              <div class="row mb-3">
                              <div class="col-md-4">
                                  <strong>Body Weight:</strong>
                                  <div>${customer.body_weight}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Body Height:</strong>
                                  <div>${customer.body_height}</div>
                                </div>
                                <div class="col-4">
                                  <strong>BMI:</strong>
                                  <div class="">
                                    ${customer.bmi || 'N/A'}
                                  </div>
                                </div>
                              </div>

                              <div class="row mb-3">
                              <div class="col-md-4">
                                  <strong>Membership Category:</strong>
                                  <div>${customer.membership_category}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Responsible Trainer:</strong>
                                  <div>${customer.assigned_trainer ? customer.assigned_trainer.name : 'N/A'}</div>
                                </div>
                                <div class="col-4">
                                  <strong>Recomended Programs:</strong>
                                  <div class="">
                                    ${customer.programs || 'N/A'}
                                  </div>
                                </div>
                              </div>


                              <div class="row mb-3">
                              <div class="col-4">
                                  <strong>Insurance Category:</strong>
                                  <div class="">
                                    ${customer.insurance_category || 'N/A'}
                                  </div>
                                </div>
                                <div class="col-4">
                                  <strong>Health Notes:</strong>
                                  <div class="">
                                    ${customer.health_notes || 'N/A'}
                                  </div>
                                </div>
                              </div>


                                  
                                 </div><!-- printable area -->

                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Close
                                  </button>
                               <!--   <button type="button" class="btn btn-primary">Save changes</button>-->
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
