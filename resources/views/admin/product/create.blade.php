@extends('template')
@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="row mt-3">
                <div class="col-15 col-lg-20">
                    
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Tambah Produk</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route ('admin.products.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="name" class="form-control"
                                           placeholder="Masukkan nama produk" required>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-control" name="categories_id">
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" name="price" class="form-control"
                                           placeholder="Masukkan harga jual" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Harga Beli</label>
                                    <input type="number" name="purchase_price" class="form-control"
                                           placeholder="Masukkan harga beli" required>
                                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stock" class="form-control"
                                           placeholder="Masukkan stok" required>
                                </div>
                                
                                <div class="text-end">
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
