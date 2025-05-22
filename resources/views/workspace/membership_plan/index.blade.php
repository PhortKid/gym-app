@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.membership_plan.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Membership plan</h5>
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
            <th>Name</th>
            <th>Description</th>
            <th>Cost</th>
            <th>action</th>
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
    fetchCustomers();
  });

  function fetchCustomers() {
    fetch('/api/membership_plan')
      .then(response => response.json())
      .then(data => {
        const membershipPlanList = document.getElementById('membership-plan-list');
        membershipPlanList.innerHTML = ''; 

        data.forEach(membershipPlan => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td><span>${membershipPlan.name}</span></td>
            <td>${membershipPlan.description}</td>
            <td>${membershipPlan.cost}</td>  
            <td>
            

            <div class="d-flex gap-2">
            <a class="dropdown-item d-flex text-primary align-items-center px-2" href="#" data-bs-toggle="modal" data-bs-target="#editMembershipPlan${membershipPlan.id}">
              <i class="bx bx-edit-alt me-1 "></i> Edit
            </a>
            
            <a class="dropdown-item d-flex align-items-center px-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteMembershipPlan${membershipPlan.id}">
              <i class="bx bx-trash me-1"></i> Delete
            </a>
          </div>


                  <div class="modal fade" id="editMembershipPlan${membershipPlan.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Edit Membership Plan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name${membershipPlan.id}" class="form-control" placeholder="Enter Name" value="${membershipPlan.name}"/>
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" id="description${membershipPlan.id}" class="form-control" placeholder="Enter Description" value="${membershipPlan.description}" />
                                    </div>
                                    </div>
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="cost" class="form-label">Cost</label>
                                        <input type="number" step="0.01" id="cost${membershipPlan.id}" class="form-control" placeholder="Enter Cost" value="${membershipPlan.cost}" />
                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateMembershipPlan(${membershipPlan.id})">Save changes</button>
                                </div>
                                </div>
                            </div>
                            </div>





                

                  <div class="modal fade" id="deleteMembershipPlan${membershipPlan.id}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Delete Membership Plan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteMembershipPlan(${membershipPlan.id})">Delete</button>
                                </div>
                                </div>
                            </div>
                            </div>


    
                  
                </div>
              </div>
            </td>
          `;
          membershipPlanList.appendChild(row);
        });

       
        $('#membership-plan-table').DataTable();
      })
      .catch(error => console.error('Error fetching Membership plan data:', error));
  }



  //add data
function add() {
  const name = document.getElementById('name').value;
  const description = document.getElementById('description').value;
  const cost = document.getElementById('cost').value;
  const requestOptions = {
    method: "POST",
    redirect: "follow"
  };

  fetch(`/api/add_membership_plan?name=${name}&description=${description}&cost=${cost}`, requestOptions)
    .then(response => response.json())
    .then(result =>console.log(result))
    .catch((error) => console.error(error));
}


function updateMembershipPlan(id) {
  const name = document.getElementById(`name${id}`).value;
  const description = document.getElementById(`description${id}`).value;
  const cost = document.getElementById(`cost${id}`).value;

  

  fetch(`/api/update_membership_plan/${id}`, {
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



function deleteMembershipPlan(id) {
  fetch(`/api/delete_membership_plan/${id}`, {
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


</script>

@endsection
