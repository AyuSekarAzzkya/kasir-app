<h2 style="text-align:center">STRUK PEMBELIAN</h2>
<p>No Invoice: {{ $transaction->invoice_number }}</p>
<p>Kasir: {{ $transaction->user->name }}</p>
<p>Tanggal: {{ $transaction->created_at }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th>
    </tr>

    @foreach($transaction->items as $item)
    <tr>
        <td>{{ $item->product->name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ number_format($item->price) }}</td>
        <td>{{ number_format($item->subtotal) }}</td>
    </tr>
    @endforeach
</table>

<h3 style="text-align:right; margin-top:20px">
    Total: Rp {{ number_format($transaction->total) }}
</h3>
<h3 style="text-align:right">
    Bayar: Rp {{ number_format($transaction->payment) }}
</h3>
<h3 style="text-align:right">
    Kembalian: Rp {{ number_format($transaction->change) }}
</h3>
