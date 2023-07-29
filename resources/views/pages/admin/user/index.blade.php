@extends('layouts.admin')
@section('user', 'active')

@section('title', 'Admin User')

@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">User</h2>
                <p class="dashboard-subtitle" style="color: gray">Kelola Data User</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">
                                    + Tambah User Baru
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama User</th>
                                                <th>Email User</th>
                                                <th>Roles</th>
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
                emptyTable: "Tidak ada user yang tersedia", // Ganti dengan teks kustom
            },
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'email',
                name: 'email'
            }, {
                data: 'roles',
                name: 'roles'
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
