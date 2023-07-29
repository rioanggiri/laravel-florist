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
                <form action="{{ route('dashboard-account-redirect', 'admin-account') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    @if (Auth::user()->photo)
                                        <img src="{{ Storage::url($user->photo) }}" alt="foto profil" class="w-50 mb-3">
                                    @else
                                        <img alt="foto profil"
                                            src="https://ui-avatars.com/api/?name={{ Auth::user()->roles == 'ADMIN' ? 'Admin' : 'User' }}"
                                            class="img-fluid mb-3" width="200">
                                    @endif
                                    {{-- <img src="{{ Storage::url($user->photo) }}" alt="foto profil" class="w-50 mb-3"> --}}
                                    <label for="photo" class="btn btn-store px-5">
                                        Update foto profil
                                    </label>
                                    <input type="file" id="photo" name="photo" style="display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
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
