@extends('layouts.dashboard')
@section('dashboard', 'active')
@section('title', 'dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card card-body d-block">
                Welcome {{ Auth::user()->name }} di Dashboard W Florist Store
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-2">
            <h5 class="mb-3 text-black-300">Riwayat Transaksi</h5>
            @foreach ($transaction_data as $transaction)
                <a class="card card-list d-block mb-3" href="{{ route('transactions.show', $transaction->id) }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                {{ $transaction->code }}
                            </div>
                            <div class="col-md-3">
                                {{ $transaction->name }}
                            </div>
                            <div class="col-md-2">
                                {{ $transaction->total_price }}
                            </div>
                            <div class="col-md-2">
                                {{ date('d/m/Y', strtotime($transaction->created_at)) }}
                            </div>
                            <div class="col-md-2">
                                @if ($transaction->status === 'PENDING')
                                    <span class="text-danger">PENDING</span>
                                @elseif ($transaction->status === 'SUCCESS')
                                    <span class="text-success">SUKSES</span>
                                @elseif ($transaction->status === 'SHIPPING')
                                    <span class="text-info">DALAM PENGIRIMAN</span>
                                @elseif ($transaction->status === 'FINISHED')
                                    <span class="text-primary">SELESAI</span>
                                @endif
                            </div>
                            <div class="col-md-1 d-none d-md-block">
                                <img src="/images/dashboard-arrow-right.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
