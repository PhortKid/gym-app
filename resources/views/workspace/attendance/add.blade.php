<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="exampleModalLabel">New Membership Plan</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body flex-grow-1">
    <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return add()">
      
      <!-- Name -->
      <div class="col-sm-12 form-control-validation">
        <label class="form-label" for="name">Name</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-user"></i></span>
          <input type="text" id="name" class="form-control" placeholder="Membership plan name" />
        </div>
      </div>

      <!-- Description -->
      <div class="col-sm-12 form-control-validation">
        <label class="form-label" for="description">Description</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-detail"></i></span>
          <input type="text" id="description" class="form-control" placeholder="Description of the plan" />
        </div>
      </div>

      <!-- Cost -->
      <div class="col-sm-12 form-control-validation">
        <label class="form-label" for="cost">Cost</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-dollar"></i></span>
          <input type="number" id="cost" class="form-control" placeholder="12000" />
        </div>
      </div>

      <!-- Buttons -->
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </div>
    </form>
  </div>
</div>
