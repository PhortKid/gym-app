@extends('workspace_layout.app')
@section('content')
<div class="container mt-4">
<div class="mb-3">
    <label for="filter-select" class="form-label">Filter by:</label>
    <select id="filter-select" class="form-select" style="width: 200px;">
        <option value="daily">Daily</option>
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option>
    </select>
</div>
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
            <td colspan="2"><strong>Total Income</strong></td>
            <td class="text-primary"><strong id="total-income">TZS 0</strong></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Customer Income</strong></td>
            <td class="text-primary"><strong id="customer-income">TZS 0</strong></td>
        </tr>
        <tr class="table-success">
            <td colspan="2"><strong>Grand Total Income</strong></td>
            <td class="text-success"><strong id="grand-total-income">TZS 0</strong></td>
        </tr>
    </tbody>

    <tbody id="expense-rows">
        <!-- Expense categories rows go here -->
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

<script>
    /*
document.addEventListener('DOMContentLoaded', () => {
    // Fetch income data
    fetch('/api/reports/income-summary')
    .then(res => res.json())
    .then(data => {
        console.log("Income Summary Response:", data); // Debugging

        const incomeTable = document.getElementById('income-rows');
        incomeTable.innerHTML = ''; // clear only income categories rows

        data.incomeCategories.forEach(item => {
            incomeTable.innerHTML += `
                <tr>
                    <td>Income</td>
                    <td>${item.name}</td>
                    <td class="text-primary">TZS ${Number(item.amount).toLocaleString()}</td>
                </tr>
            `;
        });

        document.getElementById('total-income').innerHTML = `TZS ${Number(data.totalIncome).toLocaleString()}`;
        document.getElementById('customer-income').innerHTML = `TZS ${Number(data.customerIncome).toLocaleString()}`;
        document.getElementById('grand-total-income').innerHTML = `TZS ${Number(data.grandTotalIncome).toLocaleString()}`;

        window.grandIncome = data.grandTotalIncome;
    });

    // Fetch expense data
    fetch('/api/reports/expense-summary')
    .then(res => res.json())
    .then(data => {
        const expenseTable = document.getElementById('expense-rows');
        expenseTable.innerHTML = ''; // clear expense categories rows

        data.expenseCategories.forEach(item => {
            expenseTable.innerHTML += `
                <tr>
                    <td>Expense</td>
                    <td>${item.name}</td>
                    <td class="text-danger">TZS ${Number(item.amount).toLocaleString()}</td>
                </tr>
            `;
        });

        document.getElementById('total-expenses').innerHTML = `TZS ${Number(data.totalExpenses).toLocaleString()}`;

        const net = (window.grandIncome || 0) - data.totalExpenses;
        document.getElementById('net-position').innerHTML = `TZS ${net.toLocaleString()}`;
    });
});
*/

document.addEventListener('DOMContentLoaded', () => {
    const filterSelect = document.getElementById('filter-select');

    function loadReports(filter = 'daily') {
        // Fetch income data
        fetch(`/api/reports/income-summary?filter=${filter}`)
        .then(res => res.json())
        .then(data => {
            const incomeTable = document.getElementById('income-rows');
            incomeTable.innerHTML = '';

            data.incomeCategories.forEach(item => {
                incomeTable.innerHTML += `
                    <tr>
                        <td>Income</td>
                        <td>${item.name}</td>
                        <td class="text-primary">TZS ${Number(item.amount).toLocaleString()}</td>
                    </tr>
                `;
            });

            document.getElementById('total-income').innerHTML = `TZS ${Number(data.totalIncome).toLocaleString()}`;
            document.getElementById('customer-income').innerHTML = `TZS ${Number(data.customerIncome).toLocaleString()}`;
            document.getElementById('grand-total-income').innerHTML = `TZS ${Number(data.grandTotalIncome).toLocaleString()}`;

            window.grandIncome = data.grandTotalIncome;
        });

        // Fetch expense data
        fetch(`/api/reports/expense-summary?filter=${filter}`)
        .then(res => res.json())
        .then(data => {
            const expenseTable = document.getElementById('expense-rows');
            expenseTable.innerHTML = '';

            data.expenseCategories.forEach(item => {
                expenseTable.innerHTML += `
                    <tr>
                        <td>Expense</td>
                        <td>${item.name}</td>
                        <td class="text-danger">TZS ${Number(item.amount).toLocaleString()}</td>
                    </tr>
                `;
            });

            document.getElementById('total-expenses').innerHTML = `TZS ${Number(data.totalExpenses).toLocaleString()}`;

            const net = (window.grandIncome || 0) - data.totalExpenses;
            document.getElementById('net-position').innerHTML = `TZS ${net.toLocaleString()}`;
        });
    }

    // Initial load
    loadReports();

    // On change of filter, reload reports
    filterSelect.addEventListener('change', () => {
        loadReports(filterSelect.value);
    });
});
</script>



@endsection
