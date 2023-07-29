<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = User::where('roles', 'USER')->count();
        $revenue = Transaction::where('status', '!=', 'PENDING')->sum('total_price');
        $transaction = Transaction::count();

        // Data pendapatan harian dari transaksi
        $revenueDaily = Transaction::selectRaw('DATE(created_at) as date, SUM(total_price) as revenue')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Ubah format data agar sesuai dengan format yang dibutuhkan oleh Chart.js
        $revenueData = [];
        foreach ($revenueDaily as $data) {
            $revenueData['labels'][] = $data->date;
            $revenueData['revenue'][] = $data->revenue;
        }
        return view('pages.admin.dashboard', [
            'customer' => $customer,
            'revenue' => $revenue,
            'transaction' => $transaction,
            'revenueData' => $revenueData,
        ]);
    }
}
