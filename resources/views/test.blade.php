@extends('workspace_layout.app')
@section('content')


<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#smallModal">
  Add New Record
</button>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#smallModal">
  Add New Record
</button>
<!-- Small Modal -->
<div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
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
            <input type="text" id="name" class="form-control" placeholder="Enter Name" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="description" class="form-label">Description</label>
            <input type="text" id="description" class="form-control" placeholder="Enter Description" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="cost" class="form-label">Cost</label>
            <input type="number" step="0.01" id="cost" class="form-control" placeholder="Enter Cost" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="add()">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Small Modal -->
<div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
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
            <input type="text" id="name" class="form-control" placeholder="Enter Name" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="description" class="form-label">Description</label>
            <input type="text" id="description" class="form-control" placeholder="Enter Description" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="cost" class="form-label">Cost</label>
            <input type="number" step="0.01" id="cost" class="form-control" placeholder="Enter Cost" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="add()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Button to trigger the Small Modal -->

@endsection
