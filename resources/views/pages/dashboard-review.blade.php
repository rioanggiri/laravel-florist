@extends('layouts.dashboard')
@section('review', 'active')

@section('title', 'Review')

@push('addon-style')
    <style>
        .star {
            color: #f90;
            /* Mengganti warna bintang menjadi kuning */
        }
    </style>
@endpush
@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Ulasan Saya</h2>
                <p class="dashboard-subtitle" style="color: gray">List Ulasan</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Kode Transaksi</th>
                                                <th>Foto Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Rating</th>
                                                <th>Komentar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}'
            },
            language: {
                emptyTable: "Tidak ada ulasan yang tersedia", // Ganti dengan teks kustom
            },
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'transaction.code',
                name: 'transaction.code'
            }, {
                data: 'photos',
                name: 'photos'
            }, {
                data: 'product.name',
                name: 'product.name'
            }, {
                data: 'rating',
                name: 'rating'
            }, {
                data: 'comment',
                name: 'comment'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '15%'
            }]
        });
    </script>
@endpush
