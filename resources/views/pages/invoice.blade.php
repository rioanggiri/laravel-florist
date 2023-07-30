<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice - W Florist Pekanbaru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .invoice {
            width: 80%;
            margin: 0 auto;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
        }

        .alamat {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
        }


        .invoice-details {
            text-align: left;
        }

        .invoice-details p {
            margin: 0;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .invoice-footer {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="invoice">
        <div class="invoice-header">
            <img src="/images/logo.svg" alt="W Florist Store Logo" class="logo">
            <h1 class="invoice-title">W Florist Pekanbaru</h1>
            <div class="alamat">
                <span>Jl. Pandu No. 12, Simpang Tiga, Kec. Bukit Raya, Kota Pekanbaru, Riau, 28288</span>
            </div>
        </div>
        <hr>
        <div class="invoice-details">
            <table style="float: left">
                <tr>
                    <td>Kode Transaksi</td>
                    <td>:</td>
                    <td>{{ $transaction->code }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pemesanan</td>
                    <td>:</td>
                    <td>{{ date('H:i:s, d-m-Y', strtotime($transaction->created_at)) }}</td>
                </tr>
                <tr>
                    <td>Nama Penerima</td>
                    <td>:</td>
                    <td>{{ $transaction->name }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $transaction->address }}</td>
                </tr>
                <tr>
                    <td>No Telp/WA</td>
                    <td>:</td>
                    <td>{{ $transaction->phone }}</td>
                </tr>
            </table>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $no => $item)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>Rp. {{ number_format($item->product->price, 0, ',', '.') }}</td>
                        <td>1</td>
                        <td>Rp. {{ number_format($item->product->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="invoice-footer">
            <p>Total Pembayaran: Rp. {{ number_format($item->transaction->total_price, 0, ',', '.') }}</p>
            <table style="float: right">
                <tr>
                    <td style="text-align: center">Pekanbaru, {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        {{-- tanda tangan --}}
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">Pemilik W Florist Pekanbaru</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
