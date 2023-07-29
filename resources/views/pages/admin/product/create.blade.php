@extends('layouts.admin')
@section('produk', 'active')

@section('title', 'Admin Produk')

@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Produk</h2>
                <p class="dashboard-subtitle" style="color: gray">Tambah Produk Baru</p>
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
                                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori Produk</label>
                                                <select class="form-control select2" id="categories" name="categories_id"
                                                    data required>
                                                    <option value="" disabled selected>Pilih Kategori</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Harga Produk</label>
                                                <input type="number" name="price" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Deskripsi Produk</label>
                                                <textarea name="description" id="editor"></textarea>
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
