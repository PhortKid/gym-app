<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="exampleModalLabel">New Income Category</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body flex-grow-1">
    <form class="add-new-record pt-0 row g-2" id="form-add-new-record" >
      
      <!-- Name -->
      <div class="col-sm-12 form-control-validation">
        <label class="form-label" for="name">Amount</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-user"></i></span>
          <input type="number" id="amount" class="form-control" placeholder="Income Category name" />
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
            <option value="Cash">cash</option>
            <option value="Bank">bank</option>
            <option value="Mobile Money">mobile</option>
           </select>
      </div>
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Date</label>
          <input type="date" id="date" class="form-control"  />
      </div>
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Description</label>
        <textarea name="" id="description" cols="30" rows="3" class="form-control"></textarea>
        
      </div>
      <!-- Buttons -->
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary" onclick="add()">Submit</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </div>
    </form>
  </div>
</div>
