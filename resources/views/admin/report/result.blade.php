<div class="card mt-4">
    <div class="card-header"><strong>Hasil Laporan</strong></div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="alert alert-info">
                    <strong>Total Pendapatan:</strong><br>
                    Rp {{ number_format($transactions->sum('total'), 0, ',', '.') }}
                </div>
            </div>

            <div class="col-md-3">
                <div class="alert alert-success">
                    <strong>Jumlah Transaksi:</strong><br>
                    {{ $transactions->count() }}
                </div>
            </div>

            <div class="col-md-3">
                <div class="alert alert-warning">
                    <strong>Total Barang Terjual:</strong><br>
                    {{ TransactionItems::whereIn('transactions_id', $transactions->pluck('id'))->sum('quantity') }}
                </div>
            </div>
        </div>

        <table class="table table-bordered" id="datatable">
            <thead class="bg-primary text-white">
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $t->invoice_number }}</td>
                        <td>{{ $t->created_at }}</td>
                        <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('transaction.detail', $t->id) }}" class="btn btn-info btn-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
