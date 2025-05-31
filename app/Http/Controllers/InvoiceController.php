<?php
// app/Http/Controllers/InvoiceController.php
namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('workspace.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('workspace.invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
            'gender' => 'required',
            'amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'payment_plan' => 'required|string',
            'assigned_trainer' => 'nullable|string',
        ]);

        Invoice::create($request->all());

        return redirect()->route('invoices.index')->with('success', 'Invoice created.');
    }

    public function show(Invoice $invoice)
    {
        return view('workspace.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('workspace.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update($request->all());
        return redirect()->route('invoices.index')->with('success', 'Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted.');
    }
}
