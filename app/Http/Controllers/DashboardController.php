<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\TransactionItems;
use App\Models\Products;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalPendapatanHariIni = Transactions::whereDate('created_at', $today)->sum('total');
        $jumlahTransaksiHariIni = Transactions::whereDate('created_at', $today)->count();

        $produkTerlaris = TransactionItems::selectRaw('products_id, SUM(quantity) as total')
            ->groupBy('products_id')
            ->orderByDesc('total')
            ->with('product')
            ->first();

        $stokHabis = Products::where('stock', 0)->get();
        $stokMenipis = Products::where('stock', '<=', 5)->where('stock', '>', 0)->get();

        $transactions_today = Transactions::whereDate('created_at', $today)->get();

        return view('admin.dashboard.index', compact(
            'totalPendapatanHariIni',
            'jumlahTransaksiHariIni',
            'produkTerlaris',
            'stokHabis',
            'stokMenipis',
            'transactions_today'
        ));
    }


    public function dashboard()
    {
        $today = Carbon::today();

        $transactions_today = Transactions::whereDate('created_at', $today)->get();
        $count_today = Transactions::whereDate('created_at', $today)->count();

        return view('admin.dashboard', compact('transactions_today', 'count_today'));
    }
}
