@extends('workspace_layout.app')

@section('content')
<div class="container">
    <h3>Create Invoice</h3>
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
        </div>
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
        </div>
        <div class="mb-3">
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}" required>
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="">-- Select Gender --</option>
                <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Amount (TZS)</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
        </div>
        <div class="mb-3">
            <label>Paid Amount (TZS)</label>
            <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ old('paid_amount') }}" required>
        </div>
        <div class="mb-3">
            <label>Payment Plan</label>
            <input type="text" name="payment_plan" class="form-control" value="{{ old('payment_plan') }}" required>
        </div>
        <div class="mb-3">
            <label>Assigned Trainer</label>
            <input type="text" name="assigned_trainer" class="form-control" value="{{ old('assigned_trainer') }}">
        </div>
        <button type="submit" class="btn btn-success">Save Invoice</button>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
