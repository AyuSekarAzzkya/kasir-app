<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: 0;
            padding: 0;
        }

        h2,
        h3,
        p {
            text-align: center;
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            text-align: left;
            padding: 2px 0;
        }

        th {
            border-bottom: 1px dashed #000;
        }

        td:nth-child(3),
        td:nth-child(4) {
            text-align: right;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .total,
        .bayar,
        .kembalian {
            text-align: right;
            margin: 2px 0;
        }
    </style>
</head>

<body>
    <h2>STRUK PEMBELIAN</h2>
    <p>No Invoice: {{ $transaction->invoice_number }}</p>
    <p>Kasir: {{ $transaction->user->name }}</p>
    <p>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</p>

    <hr>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <p class="total">Total: Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
    <p class="bayar">Bayar: Rp {{ number_format($transaction->payment, 0, ',', '.') }}</p>
    <p class="kembalian">Kembalian: Rp {{ number_format($transaction->change, 0, ',', '.') }}</p>

    <hr>
    <p style="text-align:center;">Terima kasih atas pembeliannya!</p>
</body>

</html>
