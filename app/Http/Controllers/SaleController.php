<?php

// app/Http/Controllers/SaleController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items.product')->latest()->get();
        $products = Product::all();
        return view('workspace.sales.index', compact('sales', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $total = $product->selling_price * $request->quantity;

        $sale = Sale::create([
            'sale_date' => now(),
            'total_amount' => $total
        ]);

        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->selling_price,
            'total' => $total
        ]);

        // reduce stock
        $product->decrement('stock_quantity', $request->quantity);

        return redirect()->back()->with('success', 'Sale recorded successfully.');
    }

    public function destroy(Sale $sale)
    {
        // restore stock
        foreach ($sale->items as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }

        $sale->delete();

        return redirect()->back()->with('success', 'Sale deleted and stock restored.');
    }

        public function report(Request $request)
    {
        $query = Sale::with('items.product');

    // Filter by date range
    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween(DB::raw('DATE(sale_date)'), [$request->from, $request->to]);
    }

    // Filter by month
    if ($request->filled('month')) {
        $query->whereMonth('sale_date', $request->month);
    }

    // Filter by year
    if ($request->filled('year')) {
        $query->whereYear('sale_date', $request->year);
    }

    $sales = $query->orderBy('sale_date', 'desc')->get();
    $totalRevenue = $sales->sum('total_amount');

    return view('workspace.sales.report', [
        'sales' => $sales,
        'totalRevenue' => $totalRevenue,
        'selectedMonth' => $request->month,
        'selectedYear' => $request->year,
        'from' => $request->from,
        'to' => $request->to,
    ]);

        
    }


}
