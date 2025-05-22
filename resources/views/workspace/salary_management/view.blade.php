

<div class="modal fade" id="ViewSalary{{$salary->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Salary</h5>
      
      </div>
      <div class="modal-body">

      <div class="table-wrapper border-primary" id="salary-details-{{$salary->id}}" >
 
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
        
      </div>


  <!-- Invoice Details -->
  <div class="text-center mb-3">
    <h4 class="font-weight-bold">Amazing Fitness Gym  Salary</h4>
    <p><strong>Date:</strong> {{$salary->created_at->format('d M Y, H:i A')}}</p>
  </div>

  <!-- Table Container -->
  <div class=" border p-1" >
    <!-- Title -->
    <div class="text-center font-weight-bold border-bottom pb-2">
        <h5>STAFF PAYMENT SLIP</h5>
        <h6>MONTH OF: {{ \Carbon\Carbon::now()->format('F') }} -{{ \Carbon\Carbon::now()->format('Y') }}</h6>
    </div>

    <!-- Employee Details -->
    <div class="border p-2 mt-2">
        <h6 class="font-weight-bold text-center border-bottom pb-1">EMPLOYEE DETAILS</h6>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Employee Name:</div>
            <div class="col">{{ $salary->user->name }}</div>
        </div>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Employee ID:</div>
            <div class="col"> {{ $salary->user->employment_id ?? 'N/A' }}</div>
        </div>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Designation:</div>
            <div class="col">{{ $salary->user->position ?? 'N/A' }}</div>
        </div>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Bank A/C No:</div>
            <div class="col">{{ $salary->user->bank_account_no ?? 'N/A' }}</div>
        </div>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Salary For:</div>
            <div class="col">{{ $salary->date ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Earnings -->
    <div class="border p-2 mt-3">
        <h6 class="font-weight-bold text-center border-bottom pb-1">EARNINGS</h6>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Basic Salary</div>
            <div class="col text-right">{{ number_format($salary->basic_salary, 2) }}</div>
        </div>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Loan Deductions</div>
            <div class="col text-right">{{ $salary->loan_deductions > 0 ? number_format($salary->loan_deductions, 2) : '-' }}</div>
        </div>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Other Deductions</div>
            <div class="col text-right">{{ $salary->other_deduction > 0 ? number_format($salary->other_deduction, 2) : '-' }}</div>
        </div>

        <div class="row border-bottom py-1">
            <div class="col-5 font-weight-bold">Total Deductions</div>
            <div class="col text-right font-weight-bold">
                {{ $salary->loan_deductions + $salary->other_deduction > 0 ? number_format($salary->loan_deductions + $salary->other_deduction, 2) : '-' }}
            </div>
        </div>

        <div class="row border-bottom py-2">
            <div class="col-5 font-weight-bold">Net Salary</div>
            <div class="col text-right font-weight-bold text-primary">
                {{ number_format($salary->basic_salary - ($salary->loan_deductions + $salary->other_deduction), 2) }}
            </div>
        </div>
    </div>

    <!-- Signatures -->
    <div class="row mt-4">
        <div class="col text-center font-weight-bold">Employee Signature : ...................</div>
        <div class="col text-center font-weight-bold">Employer Signature : ...................</div>
    </div>

    <div class="row mt-2">
        <div class="col text-center">Date : .....................</div>
        <div class="col text-center">Date : .....................</div>
    </div>
</div>


 

  <!-- Thank You Note -->
  <div class="text-center mt-3">
    <p class="text-muted">Lipilima Apartments</p>
  </div>
  
</div>

        
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 
        <button onclick="printData({{$salary->id}})" class="btn btn-secondary">Print Salary <i class="fa fa-print"></i></button>

      {{--  <button id="export-excel" class="btn btn-primary">Export to Excel <i class="fa fa-file-excel" ></i></button>
        <button id="export-csv" class="btn btn-primary">Export to CSV <i class="fa fa-file-alt" ></i></button>--}}
      </div>
      
    </div>
  </div>
</div>







  



