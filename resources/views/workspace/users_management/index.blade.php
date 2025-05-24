@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.users_management.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Users</h5>
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
      <table id="user-table" class="table table-striped">
        <thead>
          <tr>
            <th>name</th>
  
            <th>specialization</th>
           
        
            <th>phone_number</th>
            <th>position</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="user-list" class="table-border-bottom-0">
          <!-- Rows will be inserted here dynamically -->
        </tbody>
      </table>
    </div>
  </div>
</div>



<script>

function add_user() {
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const phone_number = document.getElementById('phone_number').value;
  const position = document.getElementById('position').value;
  const specialization = document.getElementById('specialization').value;
  const password = document.getElementById('password').value;

  fetch("/api/add_user", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
    body: JSON.stringify({
      name,
      email,
      phone_number,
      position,
      specialization,
      password
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
              delay += 1200; // Increase delay between messages
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
        title: 'User added successfully!',
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
      document.getElementById('form-add-staff').reset();
      fetchUsers();

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
      console.error('Add user error:', error);
    });
}



/*
function add_user(){
    name=document.getElementById('name').value;
    email=document.getElementById('email').value;
    phone_number=document.getElementById('phone_number').value;
    position=document.getElementById('position').value;
    specialization=document.getElementById('specialization').value;
    password=document.getElementById('password').value;

    const requestOptions = {
    method: "POST",
    redirect: "follow"
    };

    fetch(`/api/add_user?name=${name}&email=${email}&password=${password}&phone_number=${phone_number}&specialization=${specialization}&position=${position}`, requestOptions)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
    }*/



document.addEventListener('DOMContentLoaded', function() {
  fetchUsers();
});

function fetchUsers() {
  fetch('/api/users')
    .then(response => response.json())
    .then(data => {
      const userList = document.getElementById('user-list');
      userList.innerHTML = ''; 

      data.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td><span>${user.name}</span></td>
      
          <td>${user.specialization}</td>
          <td>${user.phone_number}</td>
          <td>${user.position}</td>
          <td>
          <div class="d-flex align-items-center">
            <a href="#" class="text-primary me-2" data-bs-toggle="modal" data-bs-target="#editUser${user.id}">
                <i class="bx bx-show"></i> View
            </a>
            
            |
            <a href="#" class="text-danger ms-2" data-bs-toggle="modal" data-bs-target="#deleteUser${user.id}">
                <i class="bx bx-trash"></i> Delete
            </a>
            </div>
          </td>

          <!-- View User Modal -->
          <div class="modal fade" id="editUser${user.id}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel4">View Users</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-4">
                      <label class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="full_name${user.id}" value="${user.name}" />
                    </div>
                    <div class="col mb-4">
                      <label class="form-label">Email</label>
                      <input type="text" class="form-control" id="email${user.id}" value="${user.email}" />
                    </div>
                    <div class="col mb-4">
                      <label class="form-label">Position</label>
                      <input type="text" class="form-control" id="position${user.id}" value="${user.position}" />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col mb-4">
                      <label class="form-label">Specialization</label>
                      <input type="text" class="form-control" id="specialization${user.id}"  value="${user.specialization}" />
                    </div>
                  
                    <div class="col mb-4">
                      <label class="form-label">Phone Number</label>
                      <input type="text" class="form-control" id="phone_number${user.id}" value="${user.phone_number}" />
                    </div>

                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" onclick="updateUser(${user.id})">Save changes</button>
                </div>
              </div>
            </div>
          </div>




                  <div class="modal fade" id="deleteUser${user.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Delete User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                                </div>
                                </div>
                            </div>
                            </div>

        `;
        userList.appendChild(row);
      });

      // Initialize DataTable
      $('#user-table').DataTable();
    })
    .catch((error) => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: `Error fetching user data`,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'z-top'
        }
      });
    });
}

//UPDATE

function updateUser(id) {
 const   name=document.getElementById(`full_name${id}`).value;
 const   email=document.getElementById(`email${id}`).value;
 const   phone_number=document.getElementById(`phone_number${id}`).value;
 const   position=document.getElementById(`position${id}`).value;
 const   specialization=document.getElementById(`specialization${id}`).value;

 


  fetch(`/api/update_user/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ name, email,phone_number, position,specialization })
  })
  .then(response => {
   // response.json();
    if (!response.ok) throw new Error("Failed to update");
    return response.json();
  })
  .then(() => {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: `User Updated`,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'z-top'
        }
      });
    fetchUsers();
    const modal = bootstrap.Modal.getInstance(document.getElementById(`editUser${id}`));
    modal.hide();
  })
  .catch(error => {
    console.error('Update error:', error);
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: `Update error`,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
          popup: 'z-top'
        }
      });
  });
  
  
}

//delete 

function deleteUser(id) {
  fetch(`/api/delete_user/${id}`, {
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
      title: 'User deleted',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
        popup: 'z-top animate__animated animate__fadeInDown'
      }
    });

    // Refresh customer list
    fetchUsers();

    // Funga modal
    const modalElement = document.getElementById(`deleteUser${id}`);
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
