<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="exampleModalLabel">New Membership Plan</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body flex-grow-1">
    <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return add()">
      
      <!-- Name -->
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Member</label>
           <select name="" id="member_id" class="form-control chosen-select">
            <option value="">-- Select Member --</option>
           </select>
      </div>
      <!-- Buttons -->
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary" onclick="add()">Submit</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </div>
    </form>
  </div>
</div>
