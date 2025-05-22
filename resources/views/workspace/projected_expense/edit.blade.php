

<div class="modal fade" id="editModal{{ $projected_expense->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Projected Expense</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('projected_expenses.update', $projected_expense->id) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
      <div class="modal-body">
     
                <div class="mb-3">
                    <label>Daily</label>
                    <input type="number" name="daily" class="form-control" value="{{ $projected_expense->daily }}" step="0.01">
                </div>
                <div class="mb-3">
                    <label>Monthly</label>
                    <input type="number" name="monthly" class="form-control" value="{{ $projected_expense->monthly }}" step="0.01">
                </div>
                <div class="mb-3">
                    <label>Annual</label>
                    <input type="number" name="annual" class="form-control" value="{{ $projected_expense->annual }}" step="0.01">
                </div>
          
      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>