@extends('template')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush
@section('content')
    <div class="container">

        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Produk</h3>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Data Produk</h4>

                            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i> Tambah Produk
                            </a>

                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tableProducts" class="table table-bordered table-striped">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Harga Jual</th>
                                            <th>Harga Beli</th>
                                            <th>Stok</th>
                                            <th>Barcode</th>
                                            <th>Kode Produk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
        $('#tableProducts').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.products.data') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'category.name',
                    name: 'category.name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'purchase_price',
                    name: 'purchase_price'
                },
                {
                    data: 'stock',
                    name: 'stock'
                },
                {
                    data: 'barcode_html',
                    name: 'barcode_html',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'barcode',
                    name: 'barcode'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    </script>
@endpush
