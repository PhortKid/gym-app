@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.income.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Income</h5>
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
      <table id="income-table" class="table table-striped">
        <thead>
          <tr>
            <th>Amount</th>
            <th>Category</th>
            <th>Date</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="income-list" class="table-border-bottom-0">
        
        </tbody>
      </table>
    </div>
  </div>
</div>



 


<script>
  //fetch Income Category
function fetchIncomeCategories() {
  fetch("/api/income_category") 
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



  //Function to fetch and display customer data
  document.addEventListener('DOMContentLoaded', function() {
    fetchIncome();
  });

  function fetchIncome() {
    fetch('/api/income')
      .then(response => response.json())
      .then(data => {
        const incomeList = document.getElementById('income-list');
        incomeList.innerHTML = ''; 

        data.forEach(income => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${income.amount}</span></td>
            <td><span>${income.category}</span></td>
            <td><span>${income.date}</span></td>
            <td><span>${income.description}</span></td>
            <td>
            

            <div class="d-flex gap-2">
            <a class="dropdown-item d-flex text-primary align-items-center px-2" href="#" data-bs-toggle="modal" data-bs-target="#editIncome${income.id}">
              <i class="bx bx-edit-alt me-1 "></i> Edit
            </a>
            
            <a class="dropdown-item d-flex align-items-center px-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteIncome${income.id}">
              <i class="bx bx-trash me-1"></i> Delete
            </a>
          </div>


                  <div class="modal fade" id="editIncome${income.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Edit Income Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="amount${income.id}" class="form-control" placeholder="Enter Amount" value="${income.amount}"/>
                                    </div>
                                    </div>

                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Income Category</label>
                                        <select name="" id="income_category_id${income.id}" class="form-control">
                                          <option value="">-- Select Income Category --</option>
                                          <option selected value="${income.category_id}">${income.category_id}</option>
                                        </select>
                                    </div>
                                    </div>

                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Date</label>
                                        <input type="text" id="date${income.id}" class="form-control"  value="${income.date}"/>
                                    </div>
                                    </div>

                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Description</label>
                                        <textarea name="" id="description${income.id}" cols="30" rows="3" class="form-control">${income.description}</textarea>
                                       
                                    </div>
                                    </div>
                                  
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateIncome(${income.id})">Save changes</button>
                                </div>
                                </div>
                            </div>
                            </div>





                

                  <div class="modal fade" id="deleteIncome${income.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Delete Income Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteIncome(${income.id})">Delete</button>
                                </div>
                                </div>
                            </div>
                            </div>


    
                  
                </div>
              </div>
            </td>
          `;
          incomeList.appendChild(row);
        });

       
        $('#income-table').DataTable();
      })
      .catch(error => console.error('Error fetching Income Category data:', error));
  }



  //add data
  function add() {
  const amount = document.getElementById('amount').value;
  const category_id = document.getElementById('income_category_id').value;
  const date = document.getElementById('date').value;
  const description = document.getElementById('description').value;
  const payment_type = document.getElementById('payment_type').value;

  const data = {
    amount,
    category_id,
    date,
    description,
    payment_type
  };

  const requestOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data),
    redirect: "follow"
  };

  fetch("/api/add_income", requestOptions)
    .then(response => response.json())
    .then(result => console.log(result))
    .catch(error => console.error('Error:', error));
}


function updateIncome(id) {
  const amount = document.getElementById(`amount${id}`).value;
  const category_id = document.getElementById(`income_category_id${id}`).value;
  const date = document.getElementById(`date${id}`).value;
  const description = document.getElementById(`description${id}`).value;

  fetch(`/api/update_income/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ amount, category_id, date, description })
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

      // Success
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Income updated successfully!',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'z-top animate__animated animate__fadeInDown'
        }
      });

      fetchIncome();
      const modal = bootstrap.Modal.getInstance(document.getElementById(`editIncome${id}`));
      modal.hide();
    })
    .catch(error => {
      if (error.message !== 'Validation errors occurred.') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Failed to update income.',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'z-top animate__animated animate__fadeInDown'
          }
        });
      }
      console.error('Update error:', error);
    });
}




function deleteIncome(id) {
  fetch(`/api/delete_income/${id}`, {
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
      title: 'Income Category deleted',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
        popup: 'z-top animate__animated animate__fadeInDown'
      }
    });

    // Refresh customer list
   fetchIncome();

    // Funga modal
    const modalElement = document.getElementById(`deleteIncome${id}`);
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
