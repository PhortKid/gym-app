@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.expense_category.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Expense Category</h5>
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
      <table id="expense-category-table" class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
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
  // Function to fetch and display customer data
  document.addEventListener('DOMContentLoaded', function() {
    fetchIncomeCategory();
  });

  function fetchIncomeCategory() {
    fetch('/api/expense_category')
      .then(response => response.json())
      .then(data => {
        const expenseCategoryList = document.getElementById('membership-plan-list');
        expenseCategoryList.innerHTML = ''; 

        data.forEach(expenseCategory => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${expenseCategory.name}</span></td>
            <td>
            

            <div class="d-flex gap-2">
            <a class="dropdown-item d-flex text-primary align-items-center px-2" href="#" data-bs-toggle="modal" data-bs-target="#editIncomeCategory${expenseCategory.id}">
              <i class="bx bx-edit-alt me-1 "></i> Edit
            </a>
            
            <a class="dropdown-item d-flex align-items-center px-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteIncomeCategory${expenseCategory.id}">
              <i class="bx bx-trash me-1"></i> Delete
            </a>
          </div>


                  <div class="modal fade" id="editIncomeCategory${expenseCategory.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Edit Expense Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name${expenseCategory.id}" class="form-control" placeholder="Enter Name" value="${expenseCategory.name}"/>
                                    </div>
                                    </div>
                                  
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateIncomeCategory(${expenseCategory.id})">Save changes</button>
                                </div>
                                </div>
                            </div>
                            </div>





                

                  <div class="modal fade" id="deleteIncomeCategory${expenseCategory.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Delete Expense Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteIncomeCategory(${expenseCategory.id})">Delete</button>
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

       
        $('#expense-category-table').DataTable();
      })
      .catch(error => console.error('Error fetching Expense Category data:', error));
  }



  //add data
function add() {
  const name = document.getElementById('name').value;
  const requestOptions = {
    method: "POST",
    redirect: "follow"
  };

  fetch(`/api/add_expense_category?name=${name}`, requestOptions)
    .then(response => response.json())
    .then(result =>console.log(result))
    .catch((error) => console.error(error));
}


function updateIncomeCategory(id) {
  const name = document.getElementById(`name${id}`).value;

  

  fetch(`/api/update_expense_category/${id}`, {
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
    fetchIncomeCategory();
    const modal = bootstrap.Modal.getInstance(document.getElementById(`editIncomeCategory${id}`));
    modal.hide();
  })
  .catch(error => {
    console.error('Update error:', error);
    alert('Failed to update.');
  });
  
}



function deleteIncomeCategory(id) {
  fetch(`/api/delete_expense_category/${id}`, {
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
      title: 'Expense Category deleted',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
        popup: 'z-top animate__animated animate__fadeInDown'
      }
    });

    // Refresh customer list
    fetchIncomeCategory();

    // Funga modal
    const modalElement = document.getElementById(`deleteIncomeCategory${id}`);
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
