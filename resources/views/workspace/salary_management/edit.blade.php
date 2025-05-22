<!-- Modal for Adding/Updating Salary -->
<div class="modal fade" id="EditSalary{{$salary->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Salary</h5>
      </div>
      <div class="modal-body">
        <form action="{{ route('salary_management.update',$salary->id) }}" method="POST">
          @csrf
          @method('PUT')
         

          <div class="form-group">
            <label for="basic_salary" class="col-form-label">Basic Salary:</label>
            <input type="number" name="basic_salary" id="basic_salary" class="form-control" required step="0.01" value="{{$salary->basic_salary}}">
          </div>

          <div class="form-group">
            <label for="loan_deductions" class="col-form-label">Loan Deductions:</label>
            <input type="number" name="loan_deductions" id="loan_deductions" class="form-control" step="0.01" value="{{$salary->loan_deductions}}">
          </div>

          <div class="form-group">
            <label for="other_deduction" class="col-form-label">Other Deduction:</label>
            <input type="number" name="other_deduction" id="other_deduction" class="form-control" step="0.01" value="{{$salary->other_deduction}}">
          </div>

          <div class="form-group">
            <label for="date" class="col-form-label">Date:</label>
            <input type="date" name="date" id="date" class="form-control" value="{{$salary->date}}"  required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Salary</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
