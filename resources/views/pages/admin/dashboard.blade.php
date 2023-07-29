@extends('layouts.admin')
@section('dashboard', 'active')
@section('title', 'Admin Dashboard')

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">
                    {{ Auth::user()->roles == 'ADMIN' ? 'Admin' : 'Owner' }} Dashboard</h2>
                <p class="dashboard-subtitle" style="color: gray">Halaman Administrator W Florist</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">
                                    Konsumen
                                </div>
                                <div class="dashboard-card-subtitle">
                                    {{ number_format($customer) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">
                                    Pendapatan
                                </div>
                                <div class="dashboard-card-subtitle">
                                    Rp. {{ number_format($revenue, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">
                                    Total Transaksi
                                </div>
                                <div class="dashboard-card-subtitle">
                                    {{ number_format($transaction) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <div class="card card-body d-block">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        // Ambil data dari PHP melalui Blade
        const revenueData = @json($revenueData);

        // Buat grafik menggunakan Chart.js
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line', // Ganti dengan 'bar' untuk grafik batang, atau 'pie' untuk grafik pie
            data: {
                labels: revenueData.labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: revenueData.revenue,
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang area
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Pendapatan Harian', // Judul yang ingin ditampilkan
                        font: {
                            size: 18, // Ukuran font judul
                            weight: 'bold', // Ketebalan font judul
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
