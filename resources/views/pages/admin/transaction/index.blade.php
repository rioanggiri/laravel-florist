@extends('layouts.admin')
@section('transaksi', 'active')

@section('title', 'Admin Transaksi')

@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaksi</h2>
                <p class="dashboard-subtitle" style="color: gray">Kelola Data Transaksi</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <a href="{{ route('laporan.proses') }}" class="btn btn-secondary mr-2 mb-2"
                                        target="_blank">
                                        <i class="fa fa-print"></i> Cetak Transaksi Akan Di Proses
                                    </a>
                                    <a href="{{ route('laporan.all') }}" class="btn btn-primary mr-2 mb-2" target="_blank">
                                        <i class="fa fa-print"></i> Cetak Semua Transaksi
                                    </a>
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn-warning dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-print"></i> Cetak Transaksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#cetakHarianModal">Cetak Laporan Harian</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#cetakMingguanModal">Cetak Laporan Mingguan</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#cetakBulananModal">Cetak Laporan Bulanan</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Pemesan</th>
                                                <th>Telepon/WA</th>
                                                <th>Total Harga</th>
                                                <th>Status</th>
                                                <th>Tanggal Pemesanan</th>
                                                <th>Keterangan</th>
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
<!-- Modal untuk input hari -->
<div class="modal fade" id="cetakHarianModal" tabindex="-1" role="dialog" aria-labelledby="cetakHarianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakHarianModalLabel">Cetak Laporan Harian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menginput hari -->
                <form action="{{ route('laporan.harian') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="tanggalHarian">Pilih Tanggal</label>
                        <input type="date" class="form-control" id="tanggalHarian" name="tanggal_harian" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal untuk input mingguan -->
<div class="modal fade" id="cetakMingguanModal" tabindex="-1" role="dialog" aria-labelledby="cetakMingguanModalTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakMingguanModalTitle">Cetak Laporan Mingguan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form input untuk memilih tanggal awal dan tanggal akhir -->
                <form action="{{ route('laporan.mingguan') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal untuk form input bulanan -->
<div class="modal fade" id="cetakBulananModal" tabindex="-1" role="dialog"
    aria-labelledby="cetakBulananModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakBulananModalTitle">Cetak Laporan Bulanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form input untuk memilih bulan dan tahun -->
                <form action="{{ route('laporan.bulanan') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control" required>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" name="tahun" id="tahun" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
                emptyTable: "Tidak ada transaksi yang tersedia",
            },
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'phone',
                name: 'phone'
            }, {
                data: 'total_price',
                name: 'total_price'
            }, {
                data: 'status',
                name: 'status'
            }, {
                data: 'created_at',
                name: 'created_at'
            }, {

                data: 'info',
                name: 'info'
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
