@extends('template')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush
@section('content')
    <div class="container mt-4">

        <h3 class="mb-3">Manajemen Stok Barang</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">Stok Masuk (IN)</div>
                    <div class="card-body">
                        <form action="{{ route('stock.in') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label>Produk</label>
                                <select name="product_id" class="form-control" required>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} (stok: {{ $p->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Jumlah Masuk</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Catatan</label>
                                <input type="text" name="note" class="form-control" placeholder="optional">
                            </div>
                            <button class="btn btn-success w-100">+ Tambah Stok</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">Stok Keluar (OUT)</div>
                    <div class="card-body">
                        <form action="{{ route('stock.out') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label>Produk</label>
                                <select name="product_id" class="form-control" required>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} (stok: {{ $p->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Jumlah Keluar</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Catatan</label>
                                <input type="text" name="note" class="form-control" placeholder="kerusakan/retur dll">
                            </div>
                            <button class="btn btn-danger w-100">- Kurangi Stok</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Riwayat Perubahan Stok</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="datatable">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Produk</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Catatan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($log->product)
                                                    {{ $log->product->name }}
                                                @else
                                                    <span class="text-danger">Produk dihapus / tidak ditemukan</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($log->type == 'in')
                                                    <span class="badge bg-success">IN</span>
                                                @else
                                                    <span class="badge bg-danger">OUT</span>
                                                @endif
                                            </td>
                                            <td>{{ $log->quantity }}</td>
                                            <td>{{ $log->note }}</td>
                                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada riwayat stok</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
