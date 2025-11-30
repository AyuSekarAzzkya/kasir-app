<?php

namespace App\Http\Controllers;

use App\Models\TransactionItems;
use App\Models\Transactions;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

    public function export(Request $request)
    {
        $type = $request->type;
        $date = $request->date;
        $month = $request->month;
        $year = $request->year;

        $query = \App\Models\Transactions::query();

        if ($type === 'daily' && $date) {
            $query->whereDate('created_at', $date);
        }
        if ($type === 'monthly') {
            if ($month) $query->whereMonth('created_at', $month);
            if ($year) $query->whereYear('created_at', $year);
        }
        if ($type === 'yearly' && $year) {
            $query->whereYear('created_at', $year);
        }

        $transactions = $query->with('user')->get();

        // Buat spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Invoice');
        $sheet->setCellValue('B1', 'Kasir');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Total');
        $sheet->setCellValue('E1', 'Bayar');
        $sheet->setCellValue('F1', 'Kembalian');

        $row = 2;
        foreach ($transactions as $t) {
            $sheet->setCellValue("A$row", $t->invoice_number);
            $sheet->setCellValue("B$row", $t->user->name);
            $sheet->setCellValue("C$row", $t->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue("D$row", $t->total);
            $sheet->setCellValue("E$row", $t->payment);
            $sheet->setCellValue("F$row", $t->change);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan_penjualan.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }
}
