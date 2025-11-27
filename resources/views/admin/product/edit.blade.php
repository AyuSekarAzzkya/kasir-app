@extends('template')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row mt-3">
                <div class="col-15 col-lg-20">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Produk</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-control" name="categories_id" required>
                                        <option value="" disabled>Pilih Kategori</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $product->categories_id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" name="price" class="form-control" value="{{ $product->price }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Harga Beli</label>
                                    <input type="number" name="purchase_price" class="form-control"
                                        value="{{ $product->purchase_price }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}"
                                        required>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
