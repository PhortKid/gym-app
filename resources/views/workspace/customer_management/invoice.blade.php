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
    fetch('http://127.0.0.1:8000/api/invoice')
      .then(response => response.json())
      .then(data => {
        const customerList = document.getElementById('customer-list');
        customerList.innerHTML = ''; 

        data.forEach(customer => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${customer.full_name}</span></td>
            <td>${customer.start_date}</td>
            <td>${customer.expiry_date}</td>
            <td>${customer.payment_plan}</td>
            <td>${customer.membership_type ? customer.membership_type.name : 'N/A'}</td>
            <td>${customer.payment_status}</td>
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
                                  <h5 class="modal-title" id="exampleModalLabel4">View Member</h5>
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
                                  <div class="row">
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">FullName</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.full_name}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Email</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.email}"
                                        />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Gender</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.gender}" />
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Phone Number</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.phone_number}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Nationality</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.nationality}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">start date</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.start_date}" />
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">FullName</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.expiry_date}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Next Of Kin Name</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.next_of_kin_name}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Next of Kin Relation</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.next_of_kin_relation}"/>
                                    </div>
                                  </div>


                                  <div class="row">
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Next of Kin Phone</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.next_of_kin_phone}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Payment Plan</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.payment_plan}" />
                                    </div>
                                 

                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">preferred_workout_time</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                        value="${customer.preferred_workout_time}"  />
                                  </div>

                                  <div class="row">
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">membership_type_id</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                          value="${customer.membership_type ? customer.membership_type.name : 'N/A'}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">assigned_trainer_id</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                         value="${customer.assigned_trainer ? customer.assigned_trainer.name : 'N/A'}" />
                                    </div>
                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">customer.profile_photo</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                         value="${customer.profile_photo}" />
                                    </div>
                                  </div>

                                  <div class="row">
                                  <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">health_notes</label>
                                      <textarea
                                        type="text"
                                        class="form-control"
                                        >${customer.health_notes} </textarea>
                                    </div>

                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Amount</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                         value="${customer.amount}" />
                                    </div>

                                    <div class="col mb-4">
                                      <label for="nameExLarge" class="form-label">Paid Amount</label>
                                      <input
                                        type="text"
                                        id="nameExLarge"
                                        class="form-control"
                                         value="${customer.payed_amount}" />
                                    </div>
                                    </div>
                                    <!-- Footer -->
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
  fetch("http://127.0.0.1:8000/api/users") 
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


//fetch membership plan
function fetchMembershipPlan() {
  fetch("http://127.0.0.1:8000/api/membership_plan") 
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      const planSelect = document.getElementById('membership_type_id');
      planSelect.innerHTML = '<option value="">-- Select Membership Plan --</option>'; 

      data.forEach(plan => {
        const option = document.createElement('option');
        option.value = plan.id;
        option.setAttribute('data-amount', plan.cost); 
        option.textContent = plan.name; 
        planSelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching membership plans:', error);
    });
}

// Call this function when the page loads or when the modal opens
document.addEventListener('DOMContentLoaded', fetchMembershipPlan);

</script>

@endsection
