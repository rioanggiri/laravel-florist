@extends('layouts.admin')
@section('produk', 'active')

@section('title', 'Admin Produk')

@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Produk</h2>
                <p class="dashboard-subtitle" style="color: gray">Kelola Data Produk</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product.create') }}" class="btn btn-primary mb-3">
                                    + Tambah Produk Baru
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Produk</th>
                                                <th>Kategori Produk</th>
                                                <th>Harga Produk</th>
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
                emptyTable: "Tidak ada produk yang tersedia", // Ganti dengan teks kustom
            },
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'category.name',
                name: 'category.name'
            }, {
                data: 'price',
                name: 'price'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '15%'
            }]
        })
    </script>
@endpush
