@extends('workspace_layout.app')
@section('content')
<div class="container mt-4">
<table class="table table-bordered" id="financial-summary">
    <thead class="table-dark">
        <tr>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Amount (TZS)</th>
        </tr>
    </thead>
    <tbody id="income-rows">
        <!-- Income categories rows go here -->
    </tbody>
    <tbody> 
        <tr class="table-success">
            <td colspan="2"><strong>Total Expected Income</strong></td>
            <td class="text-primary"><strong id="total-income">TZS 0</strong></td>
        </tr>
 
        <tr class="table-success">
            <td colspan="2"><strong>Current Debts</strong></td>
            <td class="text-success"><strong id="grand-total-income">TZS 0</strong></td>
        </tr>
        <tr class="table-success">
            <td colspan="2"><strong>Previous Debts</strong></td>
            <td class="text-success"><strong id="grand-total-income">TZS 0</strong></td>
        </tr>
        <tr class="table-success">
            <td colspan="2"><strong>Previous Expenditures</strong></td>
            <td class="text-success"><strong id="grand-total-income">TZS 0</strong></td>
        </tr>
    </tbody>

  
    <tbody>
        <tr class="table-success">
            <td colspan="2"><strong>Total Expenditures</strong></td>
            <td class="text-danger"><strong id="total-expenses">TZS 0</strong></td>
        </tr>

        <tr class="table-success">
            <td colspan="2"><strong>Net Position</strong></td>
            <td><strong id="net-position">TZS 0</strong></td>
        </tr>
    </tbody>
</table>

</div>


   
@endsection
