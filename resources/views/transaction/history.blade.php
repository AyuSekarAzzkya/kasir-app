@extends('template')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Riwayat Transaksi</h3>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Data Riwayat Transaksi</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Kode Transaksi</th>
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
                                                <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                                                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>

                                                <td>
                                                    <a href="{{ route('transactions.detail', $t->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        Detail
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>

    <script>
        $('#datatable').DataTable();
    </script>
@endpush
