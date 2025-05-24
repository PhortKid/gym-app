@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.customer_management.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Members</h5>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Button Container -->
    <div id="export-buttons" class="btn-group">
     
    </div>

    <!-- Add Button -->
    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record" aria-controls="add-new-record">
      <i class="icon-base bx bx-plus me-1"></i> Add
    </button>
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
         <!--   <th>Membership Type</th>-->
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
//calculate amount
const membershipTypeSelect = document.getElementById('membership_type_id');
  const paymentPlanSelect = document.getElementById('payment_plan');
  const startDateInput = document.getElementById('start_date');
  const expiryDateInput = document.getElementById('expiry_date');
  const expiryDateGroup = document.getElementById('expiry_date_group');
  const amountInput = document.getElementById('calculated_amount');

  let amountPerDay = 0;

  // Handle Membership Type selection
  membershipTypeSelect.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    amountPerDay = parseFloat(selected.getAttribute('data-amount')) || 0;
    calculateAmount();
  });

  // Handle Payment Plan changes
  paymentPlanSelect.addEventListener('change', function () {
    const plan = this.value;
    if (plan === 'Daily') {
      expiryDateGroup.style.display = 'none';
      expiryDateInput.value = '';
    } else if (plan === 'Monthly') {
      expiryDateGroup.style.display = 'block';
    }
    calculateAmount();
  });

  // Calculate Amount on start or end date change
  startDateInput.addEventListener('change', calculateAmount);
  expiryDateInput.addEventListener('change', calculateAmount);

  function calculateAmount() {
    const plan = paymentPlanSelect.value;
    const start = new Date(startDateInput.value);
    const end = new Date(expiryDateInput.value);
    let days = 1;

    if (plan === 'Monthly' && startDateInput.value && expiryDateInput.value) {
      const diffTime = end - start;
      days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

      // Validate max 31 days
      if (days > 31) {
        alert("Please select a duration of 31 days or less.");
        expiryDateInput.value = '';
        amountInput.value = '';
        return;
      }

    } else if (plan === 'Daily' && startDateInput.value) {
      days = 1;
    }

    const total = amountPerDay * days;
    amountInput.value = total || '';
  }

  // Hide expiry date initially
  document.addEventListener('DOMContentLoaded', () => {
    expiryDateGroup.style.display = 'none';
  });

//endof calculate amount

//paid and not paid function
document.addEventListener('DOMContentLoaded', function () {
    const paymentStatus = document.getElementById('payment_status');
    const paidAmountWrapper = document.getElementById('paid_amount_wrapper');
    const paidAmountInput = document.getElementById('paid_amount');
    const calculatedAmount = document.getElementById('calculated_amount');
    const paymentMethodWrapper=document.getElementById('payment_method_wrapper');

    // On payment status change
    paymentStatus.addEventListener('change', function () {
      const selected = this.value;
      if (selected === 'Full Paid' || selected === 'Partial') {
        paidAmountWrapper.style.display = 'block';
        paymentMethodWrapper.style.display = 'block';
      } else {
        paidAmountWrapper.style.display = 'none';
        paymentMethodWrapper.style.display = 'none';
        paidAmountInput.value = '';
      }
    });

    // Validate against calculated amount
    paidAmountInput.addEventListener('input', function () {
      const requiredAmount = parseFloat(calculatedAmount.value) || 0;
      const enteredAmount = parseFloat(this.value) || 0;

      if (enteredAmount > requiredAmount) {
        alert(`Paid amount cannot exceed total amount of ${requiredAmount}`);
        this.value = '';
      }
    });
  });
//end



  // Function to fetch and display customer data
  document.addEventListener('DOMContentLoaded', function() {
    fetchCustomers();
  });

  function fetchCustomers() {
    fetch('/api/customer')
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
          <!--  <td>${customer.membership_type ? customer.membership_type.name : 'N/A'}</td>-->
            <td>${customer.payment_status}</td>
            <td>


            <div class="d-flex align-items-center">
            <a href="#" class="text-info me-3" data-bs-toggle="modal" data-bs-target="#viewCustomer${customer.id}">
              <i class="bx bx-show me-1"></i> View
            </a>
            |
            <a href="#" class="text-warning mx-3" data-bs-toggle="modal" data-bs-target="#Pay${customer.id}">
              <i class="bx bx-add me-1"></i> Pay
            </a> 
            |
            <a href="#" class="text-danger ms-3"  onclick="deleteCustomer(${customer.id})">
              <i class="bx bx-trash me-1"></i> Delete
            </a>
          </div>

            </td>
                  <!-- View Customer Modal -->
                    <div class="modal fade" id="viewCustomer${customer.id}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">View Member</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">


                          <!-- Header -->
                            <div class="report-header d-flex justify-content-between align-items-center">
                              <div class="d-flex align-items-center">
                                <img src="{{ asset('favicon.png') }}" alt="Company Logo" class="company-logo me-3">
                                <div>
                                  <h3 class="mb-1">AMAZING FITNESS GYM</h3>
                                  <p class="mb-0">Fitness & Wellness Center</p>
                                  <p class="mb-0">Email: info@gymfitsolutions.com | Phone:</p>
                                  <p class="mb-0">Address:Mshindo, Iringa, Tanzania</p>
                                </div>
                              </div>
                              <div class="text-end">
                                <h5 class="mb-1">View Member</h5>
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
                                  <strong>Membership Type:</strong>
                                  <div>${customer.membership_type ? customer.membership_type.name : 'N/A'}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Responsible Trainer:</strong>
                                  <div>${customer.assigned_trainer ? customer.assigned_trainer.name : 'N/A'}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Amount:</strong>
                                  <div>${customer.amount}TZS</div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-4">
                                  <strong>Health Notes:</strong>
                                  <div class="border p-2 rounded bg-light">
                                    ${customer.health_notes || 'N/A'}
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                              Close
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>



                  <!-- Pay Modal -->
                    <div class="modal fade" id="Pay${customer.id}" tabindex="-1" aria-hidden="true">
                     <form action="/pay" method="POST">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Pay</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                         
                          <div class="modal-body">


                          <!-- Name -->
                          <div class="mb-3">
                            <label class="form-label">Full name</label>
                            <input type="text" class="form-control" value="${customer.full_name}" disabled>
                            <input type="hidden"  value="${customer.id}" class="form-control"  name="member_id">
                          </div>

                          <div class="mb-3">
                            <label class="form-label">Payment Type</label>
                            <select name="payment_method"  class="form-control" >
                              <option value="Cash">Cash</option>
                              <option value="Bank">Bank</option>
                              <option value="Mobile Money">Mobile Money</option>
                            </select>
                          </div>


                          <!-- Amount -->
                          <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control"  name="amount">
                          </div>

                          <!-- Date -->
                          <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control"  name="date">
                          </div>

                      

                           </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                              Close
                            </button>
                              <input type="submit" class="btn btn-secondary" value="Pay"/>
                            </div>
                        
                          
                        </div>
                      </div>
                        </form>
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


//fetch membership plan
function fetchMembershipPlan() {
  fetch("/api/membership_plan") 
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
        option.textContent = plan.name+' '+plan.cost+' TZS'; 
        planSelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching membership plans:', error);
    });
}

// Call this function when the page loads or when the modal opens
document.addEventListener('DOMContentLoaded', fetchMembershipPlan);


function  addCustomer(){
 
  const full_name = document.getElementById('full_name').value;
  const phone_number = document.getElementById('phone_number').value;
  const email = document.getElementById('email').value;
  const gender= document.getElementById('gender').value;
  const nationality = document.getElementById('nationality').value;
  const address= document.getElementById('address').value;
  const next_of_kin_name = document.getElementById('next_of_kin_name').value;
  const next_of_kin_relation = document.getElementById('next_of_kin_relation').value;
  const next_of_kin_phone = document.getElementById('next_of_kin_phone').value;
  const membership_type_id= document.getElementById('membership_type_id').value;
  const start_date = document.getElementById('start_date').value;
  const expiry_date= document.getElementById('expiry_date').value;
  const payment_plan = document.getElementById('payment_plan').value;
  const payment_status= document.getElementById('payment_status').value;
  const health_notes = document.getElementById('health_notes').value;
  const preferred_workout_time= document.getElementById('preferred_workout_time').value;
  const assigned_trainer_id = document.getElementById('assigned_trainer_id').value;
  const payed_amount = document.getElementById('paid_amount').value;
  const amount = document.getElementById('calculated_amount').value;
  const payment_method = document.getElementById('payment_method').value;
  
 
  
  fetch("/api/add_customer", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
    body: JSON.stringify({
        full_name,
        phone_number,
        email ,
        gender,
        nationality,
        address,
        next_of_kin_name,
        next_of_kin_relation,
        next_of_kin_phone,
        membership_type_id,
        start_date ,
        expiry_date,
        payment_plan ,
        payment_status,
        health_notes,
        preferred_workout_time,
        assigned_trainer_id,
        payed_amount,
        amount,
        payment_method,
    })
  })
    .then(async response => {
      const data = await response.json();

      if (!response.ok) {
        if (data.errors) {
          let delay = 0;
          for (let field in data.errors) {
            data.errors[field].forEach(errorMessage => {
              setTimeout(() => {
                Swal.fire({
                  toast: true,
                  position: 'top-end',
                  icon: 'error',
                  title: errorMessage,
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  customClass: {
                    popup: 'z-top animate__animated animate__fadeInDown'
                  }
                });
              }, delay);
              delay += 1200; 
            });
          }
        } else if (data.message) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
              popup: 'z-top animate__animated animate__fadeInDown'
            }
          });
        }

        throw new Error('Validation errors occurred.');
      }

      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Member added successfully!',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'z-top animate__animated animate__fadeInDown'
        }
      });

     const offcanvasElement = document.getElementById('add-new-record');
      const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
      if (offcanvas) {
        offcanvas.hide();
      }
      document.getElementById('form-add-new-record').reset();
      fetchCustomers();

    })
    .catch(error => {
      if (error.message !== 'Validation errors occurred.') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Failed to add user',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'z-top animate__animated animate__fadeInDown'
          }
        });
      }
      console.error('Add Member error:', error);
    });
}



//delete
function deleteCustomer(id) {
  fetch(`/api/delete_customer/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  })
  .then(response => {
    if (!response.ok) throw new Error("Failed to Delete");
    return response.json();
  })
  .then(() => {
    // Success Alert
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Expense  deleted',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
        popup: 'z-top animate__animated animate__fadeInDown'
      }
    });

    // Refresh customer list
    fetchCustomer();

    // Funga modal
    const modalElement = document.getElementById(`deleteCustomer${id}`);
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) {
      modal.hide();
    }
  })
  .catch(error => {
    console.error('Delete error:', error);

    // Error Alert
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'error',
      title: 'Failed to delete',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
        popup: 'z-top animate__animated animate__fadeInDown'
      }
    });
  });
}

</script>

@endsection
