@extends('layouts.dashboard')
@section('transaksi', 'active')

@section('title', 'Dashboard Transaksi')

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaksi</h2>
                <p class="dashboard-subtitle" style="color: gray">Hasil yang besar dimulai dengan yang kecil</p>
            </div>
            <div class="dashboard-content">
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active btn-light" id="sell-tab" data-toggle="tab" href="#sell" role="tab"
                            aria-controls="sell" aria-selected="true">Riwayat Transaksi</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                @foreach ($transactions as $transaction)
                                    <a class="card card-list d-block"
                                        href="{{ route('transactions.show', $transaction->id) }}">
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
                                                    @elseif ($transaction->status === 'CANCELLED')
                                                        <span class="text-danger">BATAL</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
