@extends('template')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Detail Transaksi</h3>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <h4 class="mb-3">Informasi Transaksi</h4>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Kode / Invoice</strong>
                                    <p>{{ $transaction->invoice_number }}</p>
                                </div>

                                <div class="col-md-4">
                                    <strong>Tanggal</strong>
                                    <p>{{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                                </div>

                                <div class="col-md-4">
                                    <strong>Total</strong>
                                    <p>Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <hr>

                            <h4 class="mb-3">Item Produk</h4>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction->items as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <h4 class="mb-3 text-end">
                                Total Pembayaran :
                                <strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong>
                            </h4>

                            <h4 class="mb-3 text-end">
                                Pembayaran :
                                <strong>Rp {{ number_format($transaction->payment, 0, ',', '.') }}</strong>
                            </h4>

                            <h4 class="mb-3 text-end">
                                Kembalian :
                                <strong>Rp {{ number_format($transaction->change, 0, ',', '.') }}</strong>
                            </h4>

                            <div class="d-flex justify-content-end gap-2">
                                <div class="text-end mt-4">
                                    <a href="{{ route('transactions.history') }}" class="btn btn-secondary">
                                        Kembali
                                    </a>
                                </div>

                                <div class="text-end mt-4">
                                    <a href="{{ route('transaction.print', $transaction->id) }}" class="btn btn-primary">
                                        Cetak Struk
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
