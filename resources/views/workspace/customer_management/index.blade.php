@extends('workspace_layout.app')
@section('content')
<div class="container mt-5">
  <div class="card">
  
    @include('workspace.customer_management.add')
    <div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Members</h5>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Button Container -->
    <div id="export-buttons" class="btn-group">
     
    </div>

    <!-- Add Button -->
    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record" aria-controls="add-new-record">
      <i class="icon-base bx bx-plus me-1"></i> Add
    </button>
  </div>
</div>

    <div class="table-responsive text-nowrap">
      <table id="customer-table" class="table table-striped">
        <thead>
          <tr>
           <th>Full Name</th>
            <th>Start Date</th>
            <th>Expire Date</th>
            <th>Payment Plan</th>
         <!--   <th>Membership Type</th>-->
            <th>Payment Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="customer-list" class="table-border-bottom-0">
          <!-- Rows will be inserted here dynamically -->
        </tbody>
      </table>
    </div>
  </div>
</div>



<script>
//calculate amount
const membershipTypeSelect = document.getElementById('membership_type_id');
  const paymentPlanSelect = document.getElementById('payment_plan');
  const startDateInput = document.getElementById('start_date');
  const expiryDateInput = document.getElementById('expiry_date');
  const expiryDateGroup = document.getElementById('expiry_date_group');
  const amountInput = document.getElementById('calculated_amount');

  let amountPerDay = 0;

  // Handle Membership Type selection
  membershipTypeSelect.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    amountPerDay = parseFloat(selected.getAttribute('data-amount')) || 0;
    calculateAmount();
  });

  // Handle Payment Plan changes
  paymentPlanSelect.addEventListener('change', function () {
    const plan = this.value;
    if (plan === 'Daily') {
      expiryDateGroup.style.display = 'none';
      expiryDateInput.value = '';
    } else if (plan === 'Monthly') {
      expiryDateGroup.style.display = 'block';
    }
    calculateAmount();
  });

  // Calculate Amount on start or end date change
  startDateInput.addEventListener('change', calculateAmount);
  expiryDateInput.addEventListener('change', calculateAmount);

  function calculateAmount() {
    const plan = paymentPlanSelect.value;
    const start = new Date(startDateInput.value);
    const end = new Date(expiryDateInput.value);
    let days = 1;

    if (plan === 'Monthly' && startDateInput.value && expiryDateInput.value) {
      const diffTime = end - start;
      days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

      // Validate max 31 days
      if (days > 31) {
        alert("Please select a duration of 31 days or less.");
        expiryDateInput.value = '';
        amountInput.value = '';
        return;
      }

    } else if (plan === 'Daily' && startDateInput.value) {
      days = 1;
    }

    const total = amountPerDay * days;
    amountInput.value = total || '';
  }

  // Hide expiry date initially
  document.addEventListener('DOMContentLoaded', () => {
    expiryDateGroup.style.display = 'none';
  });

//endof calculate amount

//paid and not paid function
document.addEventListener('DOMContentLoaded', function () {
    const paymentStatus = document.getElementById('payment_status');
    const paidAmountWrapper = document.getElementById('paid_amount_wrapper');
    const paidAmountInput = document.getElementById('paid_amount');
    const calculatedAmount = document.getElementById('calculated_amount');
    const paymentMethodWrapper=document.getElementById('payment_method_wrapper');

    // On payment status change
    paymentStatus.addEventListener('change', function () {
      const selected = this.value;
      if (selected === 'Full Paid' || selected === 'Partial') {
        paidAmountWrapper.style.display = 'block';
        paymentMethodWrapper.style.display = 'block';
      } else {
        paidAmountWrapper.style.display = 'none';
        paymentMethodWrapper.style.display = 'none';
        paidAmountInput.value = '';
      }
    });

    // Validate against calculated amount
    paidAmountInput.addEventListener('input', function () {
      const requiredAmount = parseFloat(calculatedAmount.value) || 0;
      const enteredAmount = parseFloat(this.value) || 0;

      if (enteredAmount > requiredAmount) {
        alert(`Paid amount cannot exceed total amount of ${requiredAmount}`);
        this.value = '';
      }
    });
  });
//end





@include('workspace.customer_management.script')
</script>

@endsection
