<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>W Florist Pekanbaru - {{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .laporan {
            width: 80%;
            margin: 0 auto;
        }

        .laporan-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .laporan-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 0px;
        }

        .logo {
            display: block;
            margin: 0 auto;
            max-width: 150px;
        }

        .alamat {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .underline {
            border-bottom: 1px solid black;
            /* Anda dapat mengganti warna dan ketebalan garis sesuai preferensi */
            padding-bottom: 5px;
            /* Untuk memberi sedikit ruang antara teks dan garis bawah */
        }

        .laporan-details {
            display: flex;
            justify-content: space-between;
            /* Mengatur konten menjadi posisi paling kiri dan paling kanan */
        }

        .left-content {
            flex-grow: 1;
            /* Mengizinkan elemen ini untuk mengambil seluruh sisa ruang di baris */
        }

        .right-content {
            flex-shrink: 0;
            /* Mencegah elemen ini menyusut jika kontennya melebihi lebar */
        }


        .laporan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .laporan-table th,
        .laporan-table td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: center;
        }

        .laporan-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .laporan-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .laporan-footer {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }

        .laporan-footer p {
            margin: 0;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="laporan">
        <div class="laporan-header">
            <img src="/images/logo.svg" alt="W Florist Store Logo" class="logo">
            <h1 class="laporan-title">W Florist Pekanbaru</h1>
            <div class="alamat">
                <span>Jl. Pandu No. 12, Simpang Tiga, Kec. Bukit Raya, Kota Pekanbaru, Riau, 28288</span>
            </div>
            <hr>
            <h3><u>{{ $title }}</u></h3>
            <h4>
                @if (isset($tanggalHarian))
                    Tanggal: {{ date('d-m-Y', strtotime($tanggalHarian)) }}
                @elseif (isset($tanggalAwal) && isset($tanggalAkhir))
                    Tanggal Awal: {{ date('d-m-Y', strtotime($tanggalAwal)) }} - Tanggal Akhir:
                    {{ date('d-m-Y', strtotime($tanggalAkhir)) }}
                @else
                    {{ '' }}
                @endif
            </h4>

        </div>
        <div class="laporan-details">
            <div class="left-content">
                <p>Tanggal Cetak Laporan: {{ date('d-m-Y') }}</p>
            </div>
            <div class="right-content">
                <p>Total Transaksi: {{ count($transactions) }}</p>
            </div>
        </div>
        <table class="laporan-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pemesan</th>
                    <th>Telepon/WA</th>
                    @if ($title == 'Transaksi Yang Akan Di Proses')
                        <th>Alamat</th>
                    @else
                        <th>Total Harga</th>
                    @endif
                    <th>Status</th>
                    @if ($title == 'Transaksi Yang Akan Di Proses')
                    @else
                        <th>Tanggal Pemesanan</th>
                    @endif
                    @if ($title == 'Transaksi Yang Akan Di Proses')
                        <th>Tanggal Acara</th>
                        <th>Ucapan di Papan Bunga</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $no => $transaction)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->phone }}</td>
                        @if ($title == 'Transaksi Yang Akan Di Proses')
                            <td>{{ $transaction->address }}</td>
                        @else
                            <td>Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        @endif
                        <td>
                            @if ($transaction->status === 'PENDING')
                                <span>PENDING</span>
                            @elseif ($transaction->status === 'SUCCESS')
                                <span>SUKSES</span>
                            @elseif ($transaction->status === 'SHIPPING')
                                <span>DALAM PENGIRIMAN</span>
                            @elseif ($transaction->status === 'FINISHED')
                                <span>SELESAI</span>
                            @endif
                        </td>
                        @if ($title == 'Transaksi Yang Akan Di Proses')
                        @else
                            <td>{{ date('d-m-Y', strtotime($transaction->created_at)) }}</td>
                        @endif
                        @if ($title == 'Transaksi Yang Akan Di Proses')
                            <td>{{ date('d-m-Y', strtotime($transaction->event_date)) }}</td>
                            <td>{!! $transaction->detail_order !!}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="laporan-footer">
            @if ($title == 'Transaksi Yang Akan Di Proses')
            @else
                <p>Total Pembayaran dari Semua Transaksi: Rp. {{ number_format($totalTransaksi, 0, ',', '.') }}</p>
            @endif
            <br>
            <table style="float: right">
                <tr>
                    <td style="text-align: center;">Pekanbaru, {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        {{-- tanda tangan --}}
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">Pemilik W Florist Pekanbaru</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
