@extends('template')
@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-1">Transaksi</h3>
                </div>
            </div>
            {{-- ========= MODAL SUCCESS TRANSAKSI ========= --}}
            @if (session('success'))
                <div class="modal fade" id="successModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-center p-4">
                            <h4 class="text-success fw-bold">Transaksi Berhasil!</h4>
                            <p>{{ session('success') }}</p>

                            <button class="btn btn-primary mt-3" data-bs-dismiss="modal">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            @endif


            <div class="row mt-1">
                <div class="col-12">

                    {{-- CARD INPUT TRANSAKSI --}}
                    <div class="card">
                        <div class="card-body">

                            <div class="col-md-12 order-md-1">
                                <h4 class="mb-3">Input Transaksi</h4>

                                {{-- Tidak pakai form submit karena keranjang memakai JS --}}
                                <div class="form-group mb-3">
                                    <label for="code">Kode Produk</label>
                                    <input type="text" class="form-control" id="code" placeholder="PRD-00001">
                                </div>

                                <div class="d-flex gap-3">

                                    <div class="flex-fill">
                                        <label for="nameProduct">Nama Produk</label>
                                        <input type="text" class="form-control" id="nameProduct" disabled>
                                    </div>

                                    <div class="flex-fill">
                                        <label for="priceProduct">Harga Produk</label>
                                        <input type="text" class="form-control" id="priceProduct" disabled>
                                    </div>

                                    <div class="flex-fill">
                                        <label for="amount">Jumlah</label>
                                        <input type="number" class="form-control" id="amount" disabled>
                                    </div>

                                </div>

                                <button class="btn btn-primary mt-4" id="addCart">
                                    Tambah ke Keranjang
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- 2 CARD DIBAWAHNYA --}}
                    <div class="d-flex gap-3 mt-4">

                        {{-- CARD DATA TRANSAKSI --}}
                        <div class="card flex-fill">
                            <div class="card-body">
                                <h4 class="mb-3">Data Transaksi</h4>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="transactionTable"></tbody>
                                    </table>
                                </div>

                                <h4 class="text-end mt-3">
                                    Total: <span id="displayTotal">0</span>
                                </h4>

                            </div>
                        </div>

                        {{-- CARD PEMBAYARAN --}}
                        <div class="card" style="width: 350px;">
                            <div class="card-body">
                                <h4 class="mb-3">Pembayaran</h4>

                                <form action="{{ route('transactions.store') }}" method="POST">
                                    @csrf

                                    {{-- DATA YANG DIKIRIM --}}
                                    <input type="hidden" name="cart" id="cartInput">
                                    <input type="hidden" name="total" id="paymentTotalReal">
                                    <input type="hidden" name="change" id="paymentChangeReal">

                                    <div class="mb-3">
                                        <label for="paymentTotal">Total Bayar</label>
                                        <input type="text" id="paymentTotal" class="form-control" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="paymentCash">Uang Diterima</label>
                                        <input type="number" name="payment" id="paymentCash" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="paymentChange">Kembalian</label>
                                        <input type="text" id="paymentChange" class="form-control" disabled>
                                    </div>

                                    <button class="btn btn-success w-100">
                                        Simpan Transaksi
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let cart = [];
        let total = 0;

        document.getElementById("code").addEventListener("keyup", function() {
            let code = this.value;

            if (code.length < 3) return;

            fetch(`/admin/products/by-code/${code}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        document.getElementById("nameProduct").value = data.name;
                        document.getElementById("priceProduct").value = data.price;
                        document.getElementById("amount").disabled = false;
                        window.currentProduct = data;
                    }
                });
        });

        document.getElementById("addCart").addEventListener("click", function() {
            let qty = parseInt(document.getElementById("amount").value || 0);

            if (!qty || qty <= 0) return alert("Masukkan jumlah produk!");

            let p = window.currentProduct;

            let subtotal = p.price * qty;

            cart.push({
                id: p.id,
                name: p.name,
                price: p.price,
                qty: qty,
                subtotal: subtotal
            });

            total += subtotal;
            renderTable();
        });

        function renderTable() {
            let tbody = document.getElementById("transactionTable");
            tbody.innerHTML = "";

            cart.forEach(item => {
                tbody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.qty}</td>
                <td>${item.price}</td>
                <td>${item.subtotal}</td>
            </tr>
        `;
            });

            document.getElementById("displayTotal").innerText = total;
            document.getElementById("paymentTotal").value = total;
            document.getElementById("paymentTotalReal").value = total;

            document.getElementById("cartInput").value = JSON.stringify(cart);
        }

        // Hitung kembalian
        document.getElementById("paymentCash").addEventListener("keyup", function() {
            let bayar = parseInt(this.value || 0);
            let kembali = bayar - total;

            document.getElementById("paymentChange").value = kembali;
            document.getElementById("paymentChangeReal").value = kembali;
        });

        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                let modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
            @endif
        });
    </script>
@endpush
