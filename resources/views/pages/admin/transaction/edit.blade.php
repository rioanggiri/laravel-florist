@extends('layouts.admin')
@section('transaksi', 'active')

@section('title', 'Admin Transaksi')

@push('addon-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaksi</h2>
                <p class="dashboard-subtitle" style="color: gray">Edit Transaksi</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Jika Terjadi Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('transaction.update', $item->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status Transaksi</label>
                                                <select class="form-control" id="status" name="status" data required>
                                                    <option value="{{ $item->status }}" selected>
                                                        @if ($item->status === 'PENDING')
                                                            PENDING
                                                        @elseif ($item->status === 'SUCCESS')
                                                            SUKSES
                                                        @elseif ($item->status === 'SHIPPING')
                                                            DALAM PENGIRIMAN
                                                        @elseif ($item->status === 'FINISHED')
                                                            SELESAI
                                                        @endif
                                                    </option>
                                                    <option value="" disabled>-------------</option>
                                                    <option value="PENDING">PENDING</option>
                                                    <option value="SUCCESS">SUKSES</option>
                                                    <option value="SHIPPING">DALAM PENGIRIMAN</option>
                                                    <option value="FINISHED">SELESAI</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-store px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endpush
