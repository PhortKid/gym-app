@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.attendance.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Attendance</h5>
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
      <table id="membership-plan-table" class="table table-striped">
        <thead>
          <tr>
            <th>Member name</th>
            <th>Time-in</th>
            {{--<th>action</th>--}}
          </tr>
        </thead>
        <tbody id="attendance-plan-list" class="table-border-bottom-0">
        
        </tbody>
      </table>
    </div>
  </div>
</div>



 


<script>
  // Function to fetch and display customer data
  document.addEventListener('DOMContentLoaded', function() {
    fetchAttendance();
  });

  function fetchAttendance() {
    fetch('http://127.0.0.1:8000/api/attendance')
      .then(response => response.json())
      .then(data => {
        const attendanceList = document.getElementById('attendance-plan-list');
        attendanceList.innerHTML = ''; 

        data.forEach(attendance => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${attendance.customer ? attendance.customer.full_name : 'N/A'}</span></td>
            <td>${attendance.time_in}</td>
          
        <!--    <td>
            

            <div class="d-flex gap-2">
            <a class="dropdown-item d-flex text-primary align-items-center px-2" href="#" data-bs-toggle="modal" data-bs-target="#editMembershipPlan${attendance.id}">
              <i class="bx bx-edit-alt me-1 "></i> Edit
            </a>
            
            <a class="dropdown-item d-flex align-items-center px-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteMembershipPlan${attendance.id}">
              <i class="bx bx-trash me-1"></i> Delete
            </a>
          </div>


                  <div class="modal fade" id="editAttendance${attendance.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Edit Attendance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Member Name</label>
                                        <input type="text" id="name${attendance.id}" class="form-control" disabled placeholder="Enter Name" value="${attendance.member_id}"/>
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="description" class="form-label">Time-In</label>
                                        <input type="text" id="description${attendance.id}" class="form-control"  value="${attendance.time_in}" />
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="description" class="form-label">Time-Out</label>
                                        <input type="text" id="description${attendance.id}" class="form-control"  value="${attendance.time_out}" />
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="cost" class="form-label">Work-Area</label>
                                        <input type="number" step="0.01" id="cost${attendance.id}" class="form-control" placeholder="Enter Cost" value="${attendance.workout_area}" />
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="cost" class="form-label">Trainer</label>
                                        <input type="number" step="0.01" id="cost${attendance.id}" class="form-control" placeholder="Enter Cost" value="${attendance.trainer_id}" />
                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateAttendance(${attendance.id})">Save changes</button>
                                </div>
                                </div>
                            </div>
                            </div>





                

                  <div class="modal fade" id="deleteAttendance${attendance.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Delete Attendance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteAttendance(${attendance.id})">Delete</button>
                                </div>
                                </div>
                            </div>
                        </div>
                                
                </div>
              </div>
            </td> -->
          `;
          attendanceList.appendChild(row);
        });

       
        $('#membership-plan-table').DataTable();
      })
      .catch(error => console.error('Error fetching Attendance data:', error));
  }


/*
  //add data
function add() {
    <span>${attendance.member_id}</span>
            <td>${attendance.time_in}</td>
            <td>${attendance.time_out}</td>
            <td>${attendance.workout_area}</td>  
            <td>${attendance.trainer_id}</td> 

  const member_id = document.getElementById('member_id').value;
  const time_in = document.getElementById('time_in').value;
  const time_out = document.getElementById('time_out').value;
  const workout_area = document.getElementById('workout_area').value;
  const trainer_id = document.getElementById('trainer_id').value;
  
  const requestOptions = {
    method: "POST",
    redirect: "follow"
  };

  fetch(`http://127.0.0.1:8000/api/add_membership_plan?name=${name}&description=${description}&cost=${cost}`, requestOptions)
    .then(response => response.json())
    .then(result =>console.log(result))
    .catch((error) => console.error(error));
}


function updateMembershipPlan(id) {
  const name = document.getElementById(`name${id}`).value;
  const description = document.getElementById(`description${id}`).value;
  const cost = document.getElementById(`cost${id}`).value;

  

  fetch(`http://127.0.0.1:8000/api/update_membership_plan/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ name, description, cost })
  })
  .then(response => {
    if (!response.ok) throw new Error("Failed to update");
    return response.json();
  })
  .then(() => {
    alert('Updated successfully!');
    fetchCustomers();
    const modal = bootstrap.Modal.getInstance(document.getElementById(`editMembershipPlan${id}`));
    modal.hide();
  })
  .catch(error => {
    console.error('Update error:', error);
    alert('Failed to update.');
  });
  
}
--}}
{{--

function deleteMembershipPlan(id) {
  fetch(`http://127.0.0.1:8000/api/delete_membership_plan/${id}`, {
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
      title: 'Membership plan deleted',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      customClass: {
        popup: 'z-top animate__animated animate__fadeInDown'
      }
    });

    // Refresh customer list
    fetchCustomers();

    // Funga modal
    const modalElement = document.getElementById(`deleteMembershipPlan${id}`);
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

--}}*/
</script>

@endsection
