@extends('layouts.dashboard')
@section('transaksi', 'active')

@section('title', 'Dashboard Detail Transaksi')
@push('addon-style')
    <style>
        .rating {
            display: inline-block;
        }

        .rating input {
            display: none;
        }

        .rating label {
            display: inline-block;
            cursor: pointer;
            color: #ccc;
        }

        .rating label:before {
            content: '\2605';
            font-size: 24px;
        }

        .rating input:checked~label {
            color: #f90;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #f90;
        }

        /* Membalikkan urutan bintang */
        .rating {
            direction: rtl;
        }
    </style>
@endpush

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">{{ $transaction->code }}</h2>
                <p class="dashboard-subtitle" style="color: gray">Transaksi / Detail</p>
            </div>
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table mb-0">
                                            <tr>
                                                <td class="product-title">Tanggal Acara</td>
                                                <td>:</td>
                                                <td>{{ date('d-m-Y', strtotime($transaction->event_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="product-title">Nama Penerima</td>
                                                <td>:</td>
                                                <td>{{ $transaction->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="product-title">Alamat</td>
                                                <td>:</td>
                                                <td>{{ $transaction->address }}</td>
                                            </tr>
                                            <tr>
                                                <td class="product-title">Tanggal Pemesanan</td>
                                                <td>:</td>
                                                <td>{{ date('H:i:s, d-m-Y', strtotime($transaction->created_at)) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="product-title">Telepon / WA</td>
                                                <td>:</td>
                                                <td>{{ $transaction->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td class="product-title">Total Pembayaran</td>
                                                <td>:</td>
                                                <td>Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="product-title">Status Transaksi</td>
                                                <td>:</td>
                                                <td>
                                                    @if ($transaction->status === 'PENDING')
                                                        <span class="text-danger">PENDING</span>
                                                    @elseif ($transaction->status === 'SUCCESS')
                                                        <span class="text-success">SUKSES</span>
                                                    @elseif ($transaction->status === 'SHIPPING')
                                                        <span class="text-info">DALAM PENGIRIMAN</span>
                                                    @elseif ($transaction->status === 'FINISHED')
                                                        <span class="text-primary">SELESAI</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="product-title" colspan="3">Ucapan Di Papan Bunga :</td>
                                            </tr>
                                            <tr>
                                                <td class="product-subtitle" colspan="3">{!! $transaction->detail_order !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Informasi Produk</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Foto Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                @if ($transaction->status != 'PENDING')
                                    <div class="row mt-3">
                                        <div class="col-12 text-right">
                                            <a href="{{ route('transactions.invoice', $transaction->id) }}" target="_blank"
                                                class="btn btn-store btn-lg mt-4"><i class="fa fa-print"></i>
                                                Cetak Invoice
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mt-3">
                                        <div class="col-12 text-right">
                                            <a href="{{ url($transaction->payment_url) }}" target="_blank"
                                                class="btn btn-store btn-lg mt-4"><i class="fa fa-money"></i>
                                                Bayar Sekarang
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Modal -->
@foreach ($detail as $details)
    <div class="modal fade" id="reviewModal-{{ $details->product->id }}" tabindex="-1" role="dialog"
        aria-labelledby="reviewModalLabel-{{ $details->product->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel-{{ $details->product->id }}">
                        Beri Ulasan Produk <br> {{ $details->product->name }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk memberikan ulasan -->
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $details->transaction->id }}">
                        <input type="hidden" name="product_id" value="{{ $details->product->id }}">
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5" required>
                                <label for="star5"></label>
                                <input type="radio" id="star4" name="rating" value="4" required>
                                <label for="star4"></label>
                                <input type="radio" id="star3" name="rating" value="3" required>
                                <label for="star3"></label>
                                <input type="radio" id="star2" name="rating" value="2" required>
                                <label for="star2"></label>
                                <input type="radio" id="star1" name="rating" value="1" required>
                                <label for="star1"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">Komentar:</label>
                            <textarea class="form-control" name="comment" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-store">Kirim Ulasan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@push('addon-script')
    <script>
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}'
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'photos',
                    name: 'photos',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'product.name',
                    name: 'product.name'
                },
                {
                    data: 'product.price',
                    name: 'product.price'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    </script>
@endpush
