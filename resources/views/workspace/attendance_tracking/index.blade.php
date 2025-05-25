@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Attendance Tracking</h5>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Button Container -->
    <div id="export-buttons" class="btn-group"></div>

    
   
  </div>
</div>

    <div class="table-responsive text-nowrap">
      <table id="membership-plan-table" class="table table-striped">
        <thead>
          <tr>
          <th>Member Name</th>
          <th>Status</th>
          <th>Start Date</th>
          <th>Original Expiry Date</th>
          <th>Extended Expiry Date</th>
          <th>Assigned Days</th>
          <th>Attended Days</th>
          <th>Missed Days</th>
          <th>Remaining Days</th>
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
    fetch('/api/all_attendance')
      .then(response => response.json())
      .then(data => {
        const attendanceList = document.getElementById('attendance-plan-list');
        attendanceList.innerHTML = ''; 

        data.forEach(attendance => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${attendance.customer_name}</span></td>
            <td class="${attendance.status === 'Limit Reached' ? 'text-danger' : ''}">${attendance.status}</td>
            <td>${attendance.start_date}</td>
            <td>${attendance.original_expiry_date}</td>
            <td>${attendance.extended_expiry_date}</td>
            <td>${parseInt(attendance.assigned_days)}</td>
            <td>${parseInt(attendance.attended_days)}</td>
            <td>${parseInt(attendance.missed_days)}</td>
            <td>${parseInt(attendance.remaining_days)}</td>
            

            
          
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



  //add data
function add() {
  
}
</script>

@endsection
