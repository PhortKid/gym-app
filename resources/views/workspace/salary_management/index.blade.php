@extends('workspace_layout.app')

@section('content')
<div class="container mt-4">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Salary Management</h3>
        <div class="row">
            <div class="col-10"></div>
            <div class="col-2">
              
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSalaryModal">
    <i class="fa fa-plus"></i> Add Salary
</button>
              
                @include('workspace.salary_management.add')
            </div>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fullname</th>
                    <th>Role</th>
                    <th>Basic Salary</th>
                    <th>Loan Deductions</th>
                    <th>Other Deductions</th>
                    <th>Net Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($salarys as $index =>  $salary)
                    <tr>
                       <td>{{$index + 1}}</td>
                       <td>{{$salary->user->name}} </td>
                       <td>{{$salary->user->position}}</td>
                        <td>{{$salary->basic_salary}}</td>
                        <td>{{ $salary->loan_deductions > 0 ? number_format($salary->loan_deductions, 2) : '-' }}</td>
                        <td>{{ $salary->other_deduction > 0 ? number_format($salary->other_deduction, 2) : '-' }}</td>
                        <td>{{number_format($salary->basic_salary-($salary->other_deduction+$salary->loan_deductions),2)}}</td>
                        <td>{{$salary->date}}</td>   
                        
                        <td>
                        <a href="#" class="primary" data-bs-toggle="modal" data-bs-target="#EditSalary{{$salary->id}}">
                                <i class="fa fa-pen text-eye">edit</i>
                            </a> 
                             |
                            <a href="#" class="primary" data-bs-toggle="modal" data-bs-target="#ViewSalary{{$salary->id}}">
                                <i class="fa fa-eye text-eye">view</i>
                            </a> 
                            @include('workspace.salary_management.edit')
                            @include('workspace.salary_management.view')
                        </td>
                       
                    </tr>
                    @endforeach
                   
           
            </tbody>
        </table>
    </div>
</div>
</div><!-- end of container -->
@endsection
