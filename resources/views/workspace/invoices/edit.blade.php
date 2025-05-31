@extends('workspace_layout.app')

@section('content')
<div class="container">
    <h3>Edit Invoice</h3>
    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $invoice->full_name) }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $invoice->email) }}">
        </div>
        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $invoice->phone_number) }}">
        </div>
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $invoice->start_date) }}" required>
        </div>
        <div class="mb-3">
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $invoice->expiry_date) }}" required>
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="">-- Select Gender --</option>
                <option value="Male" {{ old('gender', $invoice->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $invoice->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Amount (TZS)</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $invoice->amount) }}" required>
        </div>
        <div class="mb-3">
            <label>Paid Amount (TZS)</label>
            <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ old('paid_amount', $invoice->paid_amount) }}" required>
        </div>
        <div class="mb-3">
            <label>Payment Plan</label>
            <input type="text" name="payment_plan" class="form-control" value="{{ old('payment_plan', $invoice->payment_plan) }}" required>
        </div>
        <div class="mb-3">
            <label>Assigned Trainer</label>
            <input type="text" name="assigned_trainer" class="form-control" value="{{ old('assigned_trainer', $invoice->assigned_trainer) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Invoice</button>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
