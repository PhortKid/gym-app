@extends('workspace_layout.app')

@section('content')
<div class="container">
<div class="card mt-4">
 <div class="card-header d-flex justify-content-between align-items-center">
    <h2 class="mb-4">Product Sales</h2>

   


    <!-- Button to trigger modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSaleModal">Add Sale</button>
</div><!-- end of card header --> 

    <!-- Sales Table -->
    
    <div class="table-responsive text-nowrap">
    <table id="user-saless"   class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody >
        @foreach($sales as $sale)
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $sale->sale_date }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->total, 2) }}</td>
                <td>
                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Delete this sale?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    </div><!-- table responsive -->
</div>
</div><!-- card -->

<!-- Add Sale Modal -->
<div class="modal fade" id="addSaleModal" tabindex="-1" aria-labelledby="addSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSaleModalLabel">New Sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Product</label>
                        <select name="product_id" class="form-control" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Record Sale</button>
                </div>
            </div>
        </form>
    </div>
</div>


@if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

<script>
    $('#user-sales').DataTable();
</script>
@endsection
