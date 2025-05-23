@extends('workspace_layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Salary Report</h2>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('salary_management.salaryReport') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="date">Select Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="month">Select Month</label>
                        <select name="month" id="month" class="form-control">
                            <option value="">Select Month</option>
                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="year">Select Year</label>
                        <select name="year" id="year" class="form-control">
                            <option value="">Select Year</option>
                            @foreach(range(2020, \Carbon\Carbon::now()->year) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Content -->
    <div class="card">
        <div class="card-body printableeee" id="printable-area">
            <!-- Header Section -->
            <div class="report-header d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('favicon.png') }}" alt="Company Logo" class="company-logo me-3" style="height: 110px;">
                    <div>
                        <h4 class="mb-1">AMAZING FITNESS GYM</h4>
                        <p class="mb-0">Fitness & Wellness Center</p>
                        <p class="mb-0">Email: info@gymfitsolutions.com | Phone: +255 712 345 678</p>
                        <p class="mb-0">Address: Mshindo, Iringa, Tanzania</p>
                    </div>
                </div>
                <div class="text-end">
                    <h5 class="mb-1">Salary Report</h5>
                    <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                </div>
            </div>

            <!-- Report Title -->
            <div class="text-center mb-3">
                <h4 class="font-weight-bold">
                    Salary Report
                    @if(request()->date)
                        - {{ \Carbon\Carbon::parse(request()->date)->format('F j, Y') }}
                    @elseif(request()->month && request()->year)
                        - {{ \Carbon\Carbon::create()->month((int) request()->month)->format('F') }} {{ request()->year }}
                    @elseif(request()->month)
                        - {{ \Carbon\Carbon::create()->month((int) request()->month)->format('F') }}
                    @elseif(request()->year)
                        - {{ request()->year }}
                    @endif
                </h4>
            </div>

            <!-- Salary Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Fullname</th>
                            <th>Role</th>
                            <th>Basic Salary</th>
                            <th>Loan Deductions</th>
                            <th>Other Deductions</th>
                            <th>Net Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salaries as $index => $salary)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $salary->user->firstname }} {{ $salary->user->lastname }}</td>
                                <td>{{ $salary->user->position }}</td>
                                <td>{{ number_format($salary->basic_salary, 2) }}</td>
                                <td>{{ $salary->loan_deductions > 0 ? number_format($salary->loan_deductions, 2) : '-' }}</td>
                                <td>{{ $salary->other_deduction > 0 ? number_format($salary->other_deduction, 2) : '-' }}</td>
                                <td>{{ number_format($salary->basic_salary - ($salary->loan_deductions + $salary->other_deduction), 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Total Basic Salary</th>
                            <th>Total Loan Deduction</th>
                            <th>Total Other Deduction</th>
                            <th>Total Net Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ number_format($totalBasicSalary, 2) }}</td>
                            <td>{{ number_format($totalLoanDeductions, 2) }}</td>
                            <td>{{ number_format($totalOtherDeductions, 2) }}</td>
                            <td>{{ number_format($totalBasicSalary - ($totalLoanDeductions + $totalOtherDeductions), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Signature Section -->
            <div class="text-center mt-4">
                <p class="fw-bold">Issued By: </p>
                <p>Signature: ________________</p>
                <p>Director Of Operations</p>
                <p>Date: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
            </div>
        </div>
    </div>

 
  

    <!-- Print Button -->
    <div class="text-center mt-3">
        <button class="btn btn-success" onclick="printContent()">Print Report</button>
    </div>
</div>

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
