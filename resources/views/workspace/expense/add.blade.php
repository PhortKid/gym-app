<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="exampleModalLabel">New Expense Category</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body flex-grow-1">
  <form class="add-new-record pt-0 row g-2" id="expense-form" >
      
      <!-- Amount -->
      <div class="col-sm-12 form-control-validation">
        <label class="form-label" for="name">Amount</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text"><i class="bx bx-user"></i></span>
          <input type="number" id="amount" class="form-control" placeholder="Expense Amount" />
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
           <select name="" id="payment_method" class="form-control">
            <option value="">-- Select Payement Type --</option>
            <option value="cash">cash</option>
            <option value="bank">bank</option>
            <option value="mobile">mobile</option>
           </select>
      </div>
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Date</label>
          <input type="date" id="date" class="form-control"  />
      </div>
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Expense Category</label>
           <select name="" id="expense_category_id" class="form-control">
            <option value="">-- Select Expense Category --</option>
           </select>
      </div>
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Payed To</label>
          <input type="text" id="payed_to" class="form-control"  />
      </div>
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Payment Status</label>
           <select name="" id="status" class="form-control" required>
            <option value="">-- Select Payment Status --</option>
            <option value="Paid">Paid</option>
            <option value="Not Paid">Not Paid</option>
           </select>
      </div>
      <div class="col-sm-12 form-controlm">
        <label class="form-label" for="name">Receipt</label>
          <input type="text" id="receipt_number" class="form-control"/>
      </div>
      <!-- Buttons -->
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary" onclick="add()">Submit</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </div>
 </form>
  </div>
</div>
