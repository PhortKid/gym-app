@extends('workspace_layout.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Expected Revenue List</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Add Expected Revenue
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Daily</th>
                <th>Monthly</th>
                <th>Annual</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expectedIncomes as $income)
                <tr>
                    <td>{{ $income->id }}</td>
                    <td>{{ number_format($income->daily, 2) }}</td>
                    <td>{{ number_format($income->monthly, 2) }}</td>
                    <td>{{ number_format($income->annual, 2) }}</td>
                    <td>{{ $income->incomecategory->name ?? $income->category_id }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $income->id }}">Edit</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $income->id }}">Delete</button>
                    </td>
                </tr>

                
                @include('workspace.expected_income.edit', ['income' => $income])

             
                @include('workspace.expected_income.delete', ['income' => $income])
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('expected_incomes.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Expected Revenue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                    <label>Income Category</label>
                    <select name="income_id" id="" class="form-control">
                        @foreach($income_categories as $income_category)
                        <option value="{{$income_category->id}}">{{$income_category->name}}</option>
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
