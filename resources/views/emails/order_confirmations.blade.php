@component('mail::message')
    # Konfirmasi Pesanan

    Terima kasih telah melakukan pembelian di toko kami. Berikut adalah rincian pesanan Anda:

    Kode Pesanan: {{ $transaction->code }}
    Total Harga: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}

    Produk yang dipesan:
    @foreach ($transaction->transactionDetails as $detail)
        - {{ $detail->product->name }} (Harga: Rp {{ number_format($detail->price, 0, ',', '.') }})
    @endforeach

    Terima kasih atas pesanan Anda!

    Salam,
    Tim Dukungan Pelanggan Kami
@endcomponent
