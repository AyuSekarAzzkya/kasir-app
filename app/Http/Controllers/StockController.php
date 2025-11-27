<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\StockLogs;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function logHistory()
    {
        $products = Products::all();
        $logs = StockLogs::with('product')->latest()->get();

        return view('admin.stock_logs.index', compact('products', 'logs'));
    }

    public function stockIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'note'       => 'nullable|string'
        ]);

        $product = Products::find($validated['product_id']);

        $product->increment('stock', $validated['quantity']);

        StockLogs::create([
            'products_id' => $product->id,
            'type'        => 'in',
            'quantity'    => $validated['quantity'],
            'note'        => $validated['note'] ?? '-',
        ]);

        return back()->with('success', 'Stok berhasil ditambah!');
    }


    public function stockOut(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'note'       => 'nullable|string'
        ]);

        $product = Products::find($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $product->decrement('stock', $validated['quantity']);
        StockLogs::create([
            'products_id' => $product->id,
            'type'        => 'out',
            'quantity'    => $validated['quantity'],
            'note'        => $validated['note'] ?? '-',
        ]);

        return back()->with('success', 'Stok berhasil dikurangi!');
    }
}
