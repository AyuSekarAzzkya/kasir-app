<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\TransactionItems;
use App\Models\Transactions;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transaction.index');
    }

    public function store(Request $request)
    {
        $cart = json_decode($request->cart, true);

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Cart kosong!');
        }

        foreach ($cart as $item) {
            $product = Products::find($item['id']);

            if (!$product) {
                return back()->with("error", "Produk dengan ID {$item['id']} tidak ditemukan!");
            }

            if ($product->stock < $item['qty']) {
                return back()->with("error", "Stok {$product->name} tidak mencukupi! Sisa stok: {$product->stock}");
            }
        }

        $invoice = 'INV-' . time();

        $transaction = Transactions::create([
            'users_id' => FacadesAuth::id(),
            'invoice_number' => $invoice,
            'total' => $request->total,
            'payment' => $request->payment,
            'change' => $request->change,
        ]);

        foreach ($cart as $item) {
            TransactionItems::create([
                'transactions_id' => $transaction->id,
                'products_id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ]);

            $product = Products::find($item['id']);
            $product->reduceStock($item['qty'], "Transaksi #{$transaction->invoice_number}");
        }

        return redirect()->back()->with([
            'success' => 'Transaksi berhasil diproses!',
            'transaction_id' => $transaction->id
        ]);
    }

    public function history()
    {
        $transactions = Transactions::orderBy('id', 'DESC')->get();

        return view('transaction.history', compact('transactions'));
    }

    public function detail($id)
    {
        $transaction = Transactions::with('items.product')->findOrFail($id);

        return view('transaction.detail', compact('transaction'));
    }

    public function print($id)
    {
        $transaction = Transactions::with('items.product', 'user')->findOrFail($id);

        $pdf = FacadePdf::loadView('transaction.print', compact('transaction'));
        return $pdf->stream('struk-' . $transaction->invoice_number . '.pdf');
    }
}
