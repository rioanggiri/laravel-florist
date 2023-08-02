@extends('layouts.admin')
@section('akun', 'active')

@section('title', 'Admin Akun Saya')

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Akun Saya</h2>
                <p class="dashboard-subtitle" style="color: gray">Update profil terbaru kamu</p>
            </div>
            <div class="dashboard-content">
                <form action="{{ route('admin-account-redirect', 'admin-account') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- Jika Terjadi Error --}}
                        @if ($errors->any())
                            <div class="col-12">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="{{ Auth::user()->photo ? Storage::url($user->photo) : 'https://ui-avatars.com/api/?name=' . (Auth::user()->roles == 'ADMIN' ? 'Admin' : 'User') }}"
                                        alt="foto profil" class="w-50 mb-3">
                                    <label for="photo" class="btn btn-store px-5">
                                        Update foto profil
                                    </label>
                                    <input type="file" id="photo" name="photo" style="display: none;">
                                    <small class="form-text text-muted">Note : *File foto maksimal ukuran 1 MB</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama Saya</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email Saya</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Alamat Saya</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ $user->address }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">No. Telp/WA</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{ $user->phone }}">
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
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
