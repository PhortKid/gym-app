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
            <td>${customer.expiry_date ? customer.expiry_date : customer.start_date}</td>
            <td>${customer.payment_plan}</td>
          <!--  <td>${customer.membership_type ? customer.membership_type.name : 'N/A'}</td>-->
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
            |
            <a href="#" class="text-warning mx-3" data-bs-toggle="modal" data-bs-target="#Pay${customer.id}">
            <i class="bx bx-credit-card me-1"></i>  Pay
            </a> 
            |
            <a href="#" class="text-warning mx-3" data-bs-toggle="modal" data-bs-target="#Mark${customer.id}">
            <i class="menu-icon tf-icons bx bx-user-check"></i>  Attend
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
                              @include('header')
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
                                  <div>${customer.expiry_date ? customer.expiry_date : customer.start_date}</div> 
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
                                  <strong>Membership Type:</strong>
                                  <div>${customer.membership_type ? customer.membership_type.name : 'N/A'}</div>
                                </div>
                                <div class="col-md-4">
                                  <strong>Responsible Trainer:</strong>
                                  <div>${customer.assigned_trainer ? customer.assigned_trainer.name : 'N/A'}</div>
                                </div>
                                <div class="col-4">
                                  <strong>Health Notes:</strong>
                                  <div class="border p-2 rounded ">
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
                     <form    method="POST">
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
                            <input type="hidden"  value="${customer.id}" class="form-control"  id="pay_member_id">
                          </div>

                          <div class="mb-3">
                            <label class="form-label">Payment Type</label>
                            <select id="pay_payment_method"  class="form-control" >
                              <option value="Cash">Cash</option>
                              <option value="Bank">Bank</option>
                              <option value="Mobile Money">Mobile Money</option>
                            </select>
                          </div>


                          <!-- Amount -->
                          <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control"  id="pay_amount">
                          </div>

                          <!-- Date -->
                          <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control"  id="pay_date">
                          </div>

                      

                           </div><!-- modal-body -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                              Close
                            </button>
                              <input type="submit" class="btn btn-secondary" onclick="pay()"  value="Pay" >
                            </div><!--footer -->
                        
                          
                        </div><!-- modal-content -->
                      </div><!-- modal-dialog modal-sm -->
                      </form>
                    </div>




                    <!-- Add Attendance Modal -->
                    <div class="modal fade" id="Mark${customer.id}" tabindex="-1" aria-hidden="true">
                   
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h5 class="modal-title">Add Attendance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                         
                          <div class="modal-body">
                          <!-- Name -->
                          <div class="mb-3">
                            <label class="form-label">Full name</label>
                            <input type="text" class="form-control" value="${customer.full_name}" disabled>
                            <input type="hidden"  value="${customer.id}" class="form-control"  id="mark_member_id">
                          </div>

                          <!-- Date -->
                          <div class="mb-3">
                            <label class="form-label">Time In</label>
                            <input type="date" class="form-control"  id="time_in">
                          </div>

      
                           </div><!-- modal-body -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                              Close
                            </button>
                              <input type="submit" class="btn btn-secondary" onclick="mark()"  value="Add" >
                            </div><!--footer -->
                        
                          
                        </div><!-- modal-content -->
                      </div><!-- modal-dialog modal-sm -->
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
// const membership_type_id= document.getElementById('membership_type_id').value;
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

 //extra
 const card_number=document.getElementById('card_number').value;
 const body_weight=document.getElementById('body_weight').value;
 const body_height=document.getElementById('body_height').value;
 //const bmi=document.getElementById('bmi').value;
 const membership_category=document.getElementById('membership_category').value;
 const programs=document.getElementById('programs').value;
 const exercise_intentions=document.getElementById('exercise_intentions').value;
 const insurance_category=document.getElementById('insurance_category').value;
 

 
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
      // membership_type_id,
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

       //extra
       card_number,
       body_weight,
       body_height,
     //  bmi,
       membership_category,
       programs,
       exercise_intentions,
       insurance_category,
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


function pay(){
 
 const pay_member_id = document.getElementById('pay_member_id').value;
 const pay_payment_method = document.getElementById('pay_payment_method').value;
 const pay_amount = document.getElementById('pay_amount').value;
 const pay_date = document.getElementById('pay_date').value;

 
 fetch("/api/add_payment", {
   method: "POST",
   headers: {
     "Content-Type": "application/json",
     "Accept": "application/json"
   },
   body: JSON.stringify({
       pay_member_id,
       pay_payment_method,
       pay_amount,
       pay_date,
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
       title: 'Payment added successfully!',
       showConfirmButton: false,
       timer: 3000,
       timerProgressBar: true,
       customClass: {
         popup: 'z-top animate__animated animate__fadeInDown'
       }
     });
/*
    const offcanvasElement = document.getElementById(`Pay${pay_member_id}`);
     const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
     if (offcanvas) {
       offcanvas.hide();
     }
     document.getElementById('form-add-new-record').reset(); */
     fetchCustomers();
     window.location.reload();
     

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
     console.error('Add Payment error:', error);
   });
}

//add attendance
function mark(){
 
 const member_id = document.getElementById('mark_member_id').value;
 const time_in = document.getElementById('time_in').value;

 
 fetch("/api/add_attendance", {
   method: "POST",
   headers: {
     "Content-Type": "application/json",
     "Accept": "application/json"
   },
   body: JSON.stringify({
       member_id,
       time_in,
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
       title: 'Payment added successfully!',
       showConfirmButton: false,
       timer: 3000,
       timerProgressBar: true,
       customClass: {
         popup: 'z-top animate__animated animate__fadeInDown'
       }
     });

     fetchCustomers();
     window.location.reload();
     

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
     console.error('Add Payment error:', error);
   });
}