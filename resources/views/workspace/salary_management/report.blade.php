@extends('workspace_layout.app')

@section('content')

<h2>Salary Report</h2>

<form action="{{ route('salary_management.salaryReport') }}" method="GET">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="date">Select Date</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="month">Select Month</label>
                <select name="month" id="month" class="form-control">
                    <option value="">Select Month</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="year">Select Year</label>
                <select name="year" id="year" class="form-control">
                    <option value="">Select Year</option>
                    @foreach(range(2020, \Carbon\Carbon::now()->year) as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary mt-4">Filter</button>
        </div>
    </div>
</form>


<!-- Sehemu ya Report na Header Yenye Logo -->
<div class="printableeee" id="printable-area"> 
    <!-- Header Section (Company Info) -->
    <div class="report-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="{{ asset('favicon.png') }}" alt="Company Logo" class="company-logo me-3">
          <div>
            <h3 class="mb-1">AMAZING FITNESS GYM</h3>
            <p class="mb-0">Fitness & Wellness Center</p>
            <p class="mb-0">Email: info@gymfitsolutions.com | Phone: +255 712 345 678</p>
            <p class="mb-0">Address:Mshindo, Iringa, Tanzania</p>
          </div>
        </div>
        <div class="text-end">
          <h5 class="mb-1">Attendance Report</h5>
          <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
        </div>
      </div>


    <!-- Invoice Details -->
    <div class="text-center mb-3">
        <h4 class="font-weight-bold">Salary Report  @if(request()->date)
        - {{ \Carbon\Carbon::parse(request()->date)->format('F j, Y') }}
    @elseif(request()->month && request()->year)
        - {{ \Carbon\Carbon::create()->month((int) request()->month)->format('F') }} {{ request()->year }}
    @elseif(request()->month)
        - {{ \Carbon\Carbon::create()->month((int) request()->month)->format('F') }}
    @elseif(request()->year)
        - {{ request()->year }}
    @endif</h4>
      
    </div>



   
    <table  class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Fullname</th>
                    <th>Role</th>
                    <th>Basic Salary</th>
                    <th>Loan Deductions</th>
                    <th>Other Deductions</th>
                    <th>Net Amount</th>
                   {{-- <th>Date</th>--}}
                </tr>
            </thead>
            <tbody>
            @foreach($salaries as $index =>  $salary)
                    <tr>
                       <td>{{$index + 1}}</td>
                       <td>{{$salary->user->firstname}} {{$salary->user->lastname}}</td>
                       <td>{{$salary->user->position}}</td>
                        <td>{{number_format($salary->basic_salary,2)}}</td>
                        <td>{{ $salary->loan_deductions > 0 ? number_format($salary->loan_deductions, 2) : '-' }}</td>
                        <td>{{ $salary->other_deduction > 0 ? number_format($salary->other_deduction, 2) : '-' }}</td>
                        <td>{{ number_format($salary->basic_salary-($salary->other_deduction+$salary->loan_deductions),2)}}</td>
                        {{--<td>{{$salary->date}}</td>--}}
                       
                    </tr>
                    @endforeach
                   
           
            </tbody>
        </table>




    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Total Basic Salary</th>
                <th>Total Loan Deduction</th>
                <th>Total Other Deduction</th>
                <th>Total  Net Amount</th>
            </tr>
        </thead>
        <tbody>
            <td>{{ number_format($totalBasicSalary, 2) }}</td>
            <td>{{ number_format($totalLoanDeductions, 2) }}</td>
            <td>{{ number_format($totalOtherDeductions, 2) }}</td>
            <td>{{ number_format($totalBasicSalary-($totalLoanDeductions+$totalOtherDeductions), 2) }}</td>
        </tbody>
    </table>




        <div class="row mt-4">
        <div class="col text-center font-weight-bold" >Issued By  : Mauna Belius </div> 
        </div>
        <div class="row mt-2">
                <div class="col text-center">Signature: ...............</div>
            </div>

        <div class="row mt-2">
                <div class="col text-center">Director Of Operations</div>
            </div>
            <div class="row mt-2">
                <div class="col text-center">Date : {{ \Carbon\Carbon::now() }}  </div>
            
            </div>

            
</div>
    <!-- Thank You Note -->
    <div class="text-center mt-3">
        <p class="text-muted">LIpilimaTower!</p>
    </div>
</div>

<!-- Button ya kuprint ripoti -->
<button class="btn btn-success" onclick="printContent()">Print Report</button>

<script>
    function printContent() {
        var printArea = document.getElementById('printable-area').innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printArea;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>

@endsection
