@extends('layouts.success')

@section('title')
    Daftar Sukses
@endsection

@section('content')
    <div class="page-content page-success">
        <div class="section-success" data-aos="zoom-in">
            <div class="container">
                <div class="row align-item-center row-login justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="/images/success.svg" alt="" class="mb-4">
                        <h2>Welcome, {{ $user->name }} to W Florist Store</h2>
                        <p>
                            Kamu sudah berhasil terdaftar <br>
                            bersama kami. Let’s go pesan.
                        </p>
                        <div>
                            <a href="{{ route('dashboard') }}" class="btn btn-store w-50 mt-4">
                                Dashboard Saya
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-signup w-50 mt-4">
                                Pergi Berbelanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
