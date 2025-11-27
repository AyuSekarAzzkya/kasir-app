<?php

namespace App\Http\Controllers;

use App\Models\TransactionItems;
use App\Models\Transactions;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $transactions = collect();

        if ($request->type == 'daily') {

            $transactions = Transactions::whereDate('created_at', $request->date)->get();

        } elseif ($request->type == 'monthly') {

            $transactions = Transactions::whereYear('created_at', $request->year)
                ->whereMonth('created_at', $request->month)
                ->get();

        } elseif ($request->type == 'yearly') {

            $transactions = Transactions::whereYear('created_at', $request->year)->get();
        }

        $totalPendapatan = $transactions->sum('total');
        $jumlahTransaksi = $transactions->count();
        $totalBarangTerjual = TransactionItems::whereIn(
            'transactions_id',
            $transactions->pluck('id')
        )->sum('quantity');

        return view('admin.report.index', [
            'transactions' => $transactions,
            'totalPendapatan' => $totalPendapatan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'totalBarangTerjual' => $totalBarangTerjual,
            'request' => $request,
        ]);
    }


    public function detail($id)
    {
        $transaction = Transactions::with('items.product')->findOrFail($id);

        return view('transaction.detail', compact('transaction'));
    }
}
