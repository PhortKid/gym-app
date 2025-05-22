
<div class="modal fade" id="deleteModal{{ $projected_expense->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Are you sure you want to delete this expected income?</p>
      
      </div>
      <div class="modal-footer">
      <form action="{{ route('projected_expenses.destroy', $projected_expense->id) }}" method="POST" >
            @csrf
            @method('DELETE')
        
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>