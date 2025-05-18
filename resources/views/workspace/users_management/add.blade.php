<div class="offcanvas offcanvas-end" id="add-new-record">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title">Add Staff Member</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form id="form-add-staff" enctype="multipart/form-data"  onsubmit="return false">
      <!-- Name -->
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <!-- Role -->
      <div class="mb-3">
        <label class="form-label">Position</label>
        <select class="form-control" id="position" name="role" required>
          <option value="">-- Select Position --</option>
          <option value="Admin">Admin</option>
          <option value="Trainer">Trainer</option>
          <option value="Receptionist">Receptionist</option>
          <!-- ongeza roles zako nyingine hapa -->
        </select>
      </div>

      <!-- Specialization -->
      <div class="mb-3">
        <label class="form-label">Specialization</label>
        <input type="text" class="form-control" id="specialization" name="specialization">
      </div>

      <!-- Phone Number -->
      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
      </div>

  

      <!-- Submit Buttons -->
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary" onclick="add_user()">Submit</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </div>
    </form>
  </div>
</div>
