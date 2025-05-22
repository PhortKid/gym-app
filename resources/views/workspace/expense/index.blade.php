@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.expense.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Expense </h5>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Button Container -->
    <div id="export-buttons" class="btn-group"></div>

    <!-- Add Button -->
    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record" aria-controls="add-new-record">
      <i class="icon-base bx bx-plus me-1"></i> Add
    </button>
  </div>
</div>

    <div class="table-responsive text-nowrap">
      <table id="expense-table" class="table table-striped">
        <thead>
          <tr>
            <th>Amount</th>
            <th>Category</th>
            <th>From Income</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody id="membership-plan-list" class="table-border-bottom-0">
        
        </tbody>
      </table>
    </div>
  </div>
</div>



 


<script>
 //fetch Income Category
 function fetchIncomeCategories() {
  fetch("http://127.0.0.1:8000/api/income_category") 
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      const incomecategorySelect = document.getElementById('income_category_id');
      incomecategorySelect.innerHTML = '<option value="">-- Select Income Category --</option>'; 

      data.forEach(incomecategory => {
        const option = document.createElement('option');
        option.value = incomecategory.id; 
        option.textContent = incomecategory.name; 
        incomecategorySelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error Income Category:', error);
    });
}

// Call this function when the page loads or when the modal opens
document.addEventListener('DOMContentLoaded', fetchIncomeCategories);

 //fetch Expense Category
 function fetchExpenseCategories() {
  fetch("http://127.0.0.1:8000/api/expense_category") 
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      const expensecategorySelect = document.getElementById('expense_category_id');
      expensecategorySelect.innerHTML = '<option value="">-- Select Expense Category --</option>'; 

      data.forEach(expensecategory => {
        const option = document.createElement('option');
        option.value = expensecategory.id; 
        option.textContent = expensecategory.name; 
        expensecategorySelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error Expense Category:', error);
    });
}

// Call this function when the page loads or when the modal opens
document.addEventListener('DOMContentLoaded', fetchExpenseCategories);



  // Function to fetch and display customer data
  document.addEventListener('DOMContentLoaded', function() {
    fetchExpense();
  });

  function fetchExpense() {
    fetch('http://127.0.0.1:8000/api/expense')
      .then(response => response.json())
      .then(data => {
        const expenseCategoryList = document.getElementById('membership-plan-list');
        expenseCategoryList.innerHTML = ''; 

        data.forEach(expense => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${expense.amount}</span></td>
            <td><span>${expense.category_id}</span></td>
            <td><span>${expense.income_id}</span></td>
            <td><span>${expense.payment_method}</span></td>
            <td><span>${expense.status}</span></td>
            <td>
            

            <div class="d-flex gap-2">
            <a class="dropdown-item d-flex text-primary align-items-center px-2" href="#" data-bs-toggle="modal" data-bs-target="#editIncomeCategory${expense.id}">
              <i class="bx bx-edit-alt me-1 "></i> Edit
            </a>
            
            <a class="dropdown-item d-flex align-items-center px-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteExpense${expense.id}">
              <i class="bx bx-trash me-1"></i> Delete
            </a>
          </div>


                  <div class="modal fade" id="editIncomeCategory${expense.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Edit Expense </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Amount</label>
                                        <input type="text" id="amount${expense.id}" class="form-control" placeholder="Enter Amount" value="${expense.name}"/>
                                    </div>
                                    </div>

                                    <div class="col-sm-12 form-controlm">
                                        <label class="form-label" for="name">Income Category</label>
                                          <select name="" id="income_category_id" class="form-control">
                                            <option value="">-- Select Income Category --</option>
                                          </select>
                                      </div>

                                      <div class="col-sm-12 form-controlm">
                                        <label class="form-label" for="name">Payment Type</label>
                                          <select name="" id="payment_type" class="form-control">
                                            <option value="">-- Select Payement Type --</option>
                                            <option value="cash">cash</option>
                                            <option value="bank">bank</option>
                                            <option value="mobile">mobile</option>
                                          </select>
                                      </div>

                                      <div class="col-sm-12 form-controlm">
                                        <label class="form-label" for="name">Date</label>
                                          <input type="date" id="date" class="form-control"  />
                                      </div>

                                      <div class="col-sm-12 form-controlm">
                                        <label class="form-label" for="name">Expense Category</label>
                                          <select name="" id="expense_category_id" class="form-control">
                                            <option value="">-- Select Expense Category --</option>
                                          </select>
                                      </div>

                                      <div class="col-sm-12 form-controlm">
                                        <label class="form-label" for="name">Payed By</label>
                                          <input type="text" id="payed_by" class="form-control"  />
                                      </div>

                                      <div class="col-sm-12 form-controlm">
                                        <label class="form-label" for="name">Receipt</label>
                                          <input type="text" id="receipt" class="form-control"/>
                                      </div>
                                  
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateIncomeCategory(${expense.id})">Save changes</button>
                                </div>
                                </div>
                            </div>
                            </div>





                

                  <div class="modal fade" id="deleteExpense${expense.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Delete Expense </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteExpense(${expense.id})">Delete</button>
                                </div>
                                </div>
                            </div>
                            </div>


    
                  
                </div>
              </div>
            </td>
          `;
          expenseCategoryList.appendChild(row);
        });

       
        $('#expense-table').DataTable();
      })
      .catch(error => console.error('Error fetching Expense  data:', error));
  }



  //add data
  function add() {
  const receipt_number = document.getElementById('receipt_number').value;
  const payment_method = document.getElementById('payment_method').value;
  const amount = document.getElementById('amount').value;
  const date = document.getElementById('date').value;
  const category_id = document.getElementById('expense_category_id').value;
  const status = document.getElementById('status').value;
  const payed_to = document.getElementById('payed_to').value;
  const income_id = document.getElementById('income_category_id').value;


  
  const data = {
    receipt_number,
    payment_method,
    amount,
    date,
    category_id,
    status,
    payed_to,
    income_id
  };

  const requestOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
    body: JSON.stringify(data),
    redirect: "follow"
  };

  fetch("http://127.0.0.1:8000/api/add_expense", requestOptions)
    .then(async response => {
      const resData = await response.json();

      if (!response.ok) {
        if (resData.errors) {
          let delay = 0;
          for (let field in resData.errors) {
            resData.errors[field].forEach(errorMessage => {
              setTimeout(() => {
                Swal.fire({
                  toast: true,
                  position: 'top-end',
                  icon: 'error',
                  title: errorMessage,
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true
                });
              }, delay);
              delay += 1200;
            });
          }
        } else {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: resData.message || 'Something went wrong!',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
          });
        }
        throw new Error('Validation failed');
      }

      // Success message
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Expense added successfully!',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
      });

      // Reset form (optional)
     // document.getElementById('expense-form').reset();
      // Optionally call a function to refresh the expense list
      fetchExpense();
    })
    .catch(error => {
      if (error.message !== 'Validation failed') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Failed to add expense',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true
        });
      }
      console.error('Error:', error);
    });
    
}



function updateIncomeCategory(id) {
  const name = document.getElementById(`name${id}`).value;

  

  fetch(`http://127.0.0.1:8000/api/update_expense_category/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ name })
  })
  .then(response => {
    if (!response.ok) throw new Error("Failed to update");
    return response.json();
  })
  .then(() => {
    alert('Updated successfully!');
    fetchExpense();
    const modal = bootstrap.Modal.getInstance(document.getElementById(`editIncomeCategory${id}`));
    modal.hide();
  })
  .catch(error => {
    console.error('Update error:', error);
    alert('Failed to update.');
  });
  
}



function deleteExpense(id) {
  fetch(`http://127.0.0.1:8000/api/delete_expense/${id}`, {
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
    fetchExpense();

    // Funga modal
    const modalElement = document.getElementById(`deleteExpense${id}`);
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
