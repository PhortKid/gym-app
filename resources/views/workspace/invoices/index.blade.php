@extends('workspace_layout.app')

@section('content')
<div class="container">
    <h3>Invoices</h3>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">New Invoice</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Remaining</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->full_name }}</td>
                <td>{{ number_format($invoice->amount, 2) }} TZS</td>
                <td>{{ number_format($invoice->paid_amount, 2) }} TZS</td>
                <td>{{ number_format($invoice->amount - $invoice->paid_amount, 2) }} TZS</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewInvoice{{ $invoice->id }}">
                        View
                    </button>
                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="viewInvoice{{ $invoice->id }}" tabindex="-1" aria-labelledby="viewInvoiceLabel{{ $invoice->id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewInvoiceLabel{{ $invoice->id }}">View Invoice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="printable-area-{{ $invoice->id }}">
                                <div class="report-header d-flex justify-content-between align-items-center mb-3">
                                    {{-- include your header here --}}
                                    @include('header')
                                    <div class="text-end">
                                        <h5 class="mb-1">Invoice</h5>
                                        <p class="mb-0">Date: {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Full Name:</strong> {{ $invoice->full_name }}</div>
                                    <div class="col-md-4"><strong>Email:</strong> {{ $invoice->email }}</div>
                                    <div class="col-md-4"><strong>Phone:</strong> {{ $invoice->phone_number }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Start Date:</strong> {{ $invoice->start_date }}</div>
                                    <div class="col-md-4"><strong>Expiry Date:</strong> {{ $invoice->expiry_date }}</div>
                                    <div class="col-md-4"><strong>Gender:</strong> {{ $invoice->gender }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Amount:</strong> {{ number_format($invoice->amount, 2) }} TZS</div>
                                    <div class="col-md-4"><strong>Paid:</strong> {{ number_format($invoice->paid_amount, 2) }} TZS</div>
                                    <div class="col-md-4"><strong>Remaining:</strong> {{ number_format($invoice->amount - $invoice->paid_amount, 2) }} TZS</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Plan:</strong> {{ $invoice->payment_plan }}</div>
                                    <div class="col-md-4"><strong>Trainer:</strong> {{ $invoice->assigned_trainer ?? 'N/A' }}</div>
                                    {{-- Add Membership if applicable --}}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="printDiv('printable-area-{{ $invoice->id }}')">Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            @endforeach
        </tbody>
    </table>
</div>

<script>
function printDiv(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload(); // to reload scripts/styles after print
}
</script>
@endsection
