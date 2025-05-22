<!-- Modal for Adding/Updating Salary -->
<div class="modal fade" id="AddSalaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add/Update Salary</h5>
      </div>
      <div class="modal-body">
        <form action="{{ route('salary_management.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="user_id" class="col-form-label">User:</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} </option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="basic_salary" class="col-form-label">Basic Salary:</label>
            <input type="number" name="basic_salary" id="basic_salary" class="form-control" required step="0.01">
          </div>

          <div class="form-group">
            <label for="loan_deductions" class="col-form-label">Loan Deductions:</label>
            <input type="number" name="loan_deductions" id="loan_deductions" class="form-control" step="0.01">
          </div>

          <div class="form-group">
            <label for="other_deduction" class="col-form-label">Other Deduction:</label>
            <input type="number" name="other_deduction" id="other_deduction" class="form-control" step="0.01">
          </div>

          <div class="form-group">
            <label for="date" class="col-form-label">Date:</label>
            <input type="date" name="date" id="date" class="form-control" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Salary</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
