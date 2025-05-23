@extends('workspace_layout.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Projected Expenses List</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Add Projected Expenses
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Daily</th>
                <th>Monthly</th>
                <th>Annual</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projected_expenses as $projected_expense)
                <tr>
                    <td>{{ $projected_expense->id }}</td>
                    <td>{{ number_format($projected_expense->daily, 2) }}</td>
                    <td>{{ number_format($projected_expense->monthly, 2) }}</td>
                    <td>{{ number_format($projected_expense->annual, 2) }}</td>
                    <td>{{ $projected_expense->expensetype->name  }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $projected_expense->id }}">Edit</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $projected_expense->id }}">Delete</button>
                    </td>
                </tr>

                
                @include('workspace.projected_expense.edit', ['projected_expense' => $projected_expense])

             
                @include('workspace.projected_expense.delete', ['projected_expense' => $projected_expense])
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('projected_expenses.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Expected Income</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                    <label>Income Category</label>
                    <select name="expense_id" id="" class="form-control">
                        @foreach($expense_types as $expense_type)
                        <option value="{{$expense_type->id}}">{{$expense_type->name}}</option>
                        @endforeach
                    </select> 
                </div>

                <div class="mb-3">
                    <label>Daily</label>
                    <input type="number" name="daily" class="form-control" step="0.01">
                </div>
                <div class="mb-3">
                    <label>Monthly</label>
                    <input type="number" name="monthly" class="form-control" step="0.01">
                </div>
                <div class="mb-3">
                    <label>Annual</label>
                    <input type="number" name="annual" class="form-control" step="0.01">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>


@endsection
