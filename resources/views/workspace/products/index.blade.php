<!-- resources/views/products/index.blade.php -->

@extends('workspace_layout.app')

@section('content')
<div class="container">

<div class="card mt-4">
 <div class="card-header d-flex justify-content-between align-items-center">
    <h2 class="mb-4">Products</h2>

 

    <!-- Add Product Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>

    </div><!-- end of card header --> 


    <!-- Products Table -->
    <div class="table-responsive text-nowrap">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->purchase_price }} TZS</td>
                <td>{{ $product->selling_price }} TZS</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editProductModal{{ $product->id }}">Edit</button>

                    <!-- Delete Form -->
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $product->id }}">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label>Buying Price</label>
                                    <input type="number" name="purchase_price" value="{{ $product->purchase_price }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label>Selling Price</label>
                                    <input type="number" name="selling_price" value="{{ $product->selling_price }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label>Stock Quantity</label>
                                    <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        </tbody>
    </table>
    </div><!-- table responsive -->
</div>
</div><!-- card -->

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Purchase Price</label>
                        <input type="number" name="purchase_price" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Selling Price</label>
                        <input type="number" name="selling_price" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock_quantity" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            position: 'top-end',
            toast: true,
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@endsection
