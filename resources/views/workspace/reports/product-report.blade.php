@extends('workspace_layout.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Product Sales Report</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>In Stock</th>
                <th>Min Stock</th>
                <th>Total Sold</th>
                <th>Total Revenue (TZS)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['stock_quantity'] }}</td>
                    <td>{{ $product['min_stock_level'] }}</td>
                    <td>{{ $product['total_sold'] }}</td>
                    <td>{{ number_format($product['total_revenue'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
