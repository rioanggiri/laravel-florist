@extends('layouts.app')

@section('title')
    Keranjang
@endsection

@section('content')
    <div class="page-content page-cart">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Keranjang
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="store-cart">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless table-cart">
                            <thead>
                                <tr>
                                    <td>Foto</td>
                                    <td>Nama Produk</td>
                                    <td>Harga</td>
                                    <td>Menu</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @forelse ($carts as $cart)
                                    <tr>
                                        <td style="width: 25%;">
                                            @if (isset($cart->product->galleries) && count($cart->product->galleries) > 0)
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt="" class="cart-image">
                                            @else
                                                '<img src="/images/placeholder.png" alt="" class="cart-image">
                                            @endif
                                            {{-- @if ($cart->product->galleries)
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt="" class="cart-image">
                                            @endif --}}
                                        </td>
                                        <td style="width: 35%;">
                                            <div class="product-title">{{ $cart->product->name }}</div>
                                        </td>
                                        <td style="width: 35%;">
                                            <div class="product-title">
                                                Rp. {{ number_format($cart->product->price, 0, ',', '.') }}
                                            </div>
                                            <div class="product-subtitle">Rupiah</div>
                                        </td>
                                        <td style="width: 20%;">
                                            <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-remove-cart">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php
                                        $totalPrice += $cart->product->price;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="4" id="cart-empty" class="text-center">
                                            Ooops... Keranjang kosong nih
                                            <a href="{{ route('home') }}" class="underline">Belanja sekarang</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-4">Detail Pemesanan</h2>
                    </div>
                </div>
                <form action="{{ route('checkout') }}" method="POST" id="locations" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                    <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_date">Tanggal Acara</label>
                                <input type="date" class="form-control" id="event_date" name="event_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Penerima</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Masukkan Nama Penerima">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Alamat Penerima</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Masukkan Alamat Penerima">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telepon/WA</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Masukkan Nomor Telp/Wa">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="detail_order">Ucapan di Papan Bunga : </label>
                                <textarea name="detail_order" id="editor">
                                    <p>Kalimat ucapan di papan bunga : </p>
                                    <p>From : </p>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-delay="150">
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <h2 class="mb-2">Informasi Pembayaran</h2>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-4 col-md-2">
                        </div>
                        <div class="col-4 col-md-3">
                        </div>
                        <div class="col-4 col-md-2">
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="product-title text-success">Rp. {{ number_format($totalPrice ?? 0) }}</div>
                            <div class="product-subtitle">Total</div>
                        </div>
                        <div class="col-8 col-md-3">
                            <button type="submit" class="btn btn-store mt-4 px-4 btn-block">
                                Checkout Now
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endpush
