<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function cetakAll()
    {
        $transactions = Transaction::all();
        $title = 'Laporan Semua Transaksi';
        $totalTransaksi = $transactions->sum('total_price');

        return view('pages.admin.transaction.laporan', compact('transactions', 'title', 'totalTransaksi'));
        // // Load view laporan dan passing data
        // $pdf = PDF::loadView('pages.admin.transaction.laporan', compact('transactions', 'title'));
        // // Atur header laporan
        // $pdf->getDomPDF()->get_option('enable_html5_parser');
        // $pdf->setPaper('A4', 'potrait');
        // // Return laporan dalam bentuk PDF
        // return $pdf->download('laporan-transaksi.pdf');
    }

    public function cetakHarian(Request $request)
    {
        $request->validate([
            'tanggal_harian' => 'required|date',
        ]);

        // Ambil tanggal yang diinput oleh pengguna
        $tanggalHarian = $request->tanggal_harian;

        // Logika untuk laporan harian berdasarkan tanggal yang diinput
        $transactions = Transaction::whereDate('created_at', $tanggalHarian)->get();
        $title = 'Laporan Transaksi Harian';
        $totalTransaksi = $transactions->sum('total_price');

        return view('pages.admin.transaction.laporan', compact('transactions', 'title', 'totalTransaksi', 'tanggalHarian'));
    }

    public function cetakMingguan(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);
        // Logika untuk laporan harian berdasarkan tanggal yang diinput
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
        $transactions = Transaction::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->get();
        $title = 'Laporan Transaksi Mingguan';
        $totalTransaksi = $transactions->sum('total_price');

        return view('pages.admin.transaction.laporan', compact('transactions', 'title', 'totalTransaksi', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function cetakBulanan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $tanggalAwal = Carbon::parse("$tahun-$bulan-01")->startOfMonth();
        $tanggalAkhir = Carbon::parse("$tahun-$bulan-01")->endOfMonth();

        $transactions = Transaction::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->get();
        $title = 'Laporan Transaksi Bulanan';
        $totalTransaksi = $transactions->sum('total_price');

        return view('pages.admin.transaction.laporan', compact('transactions', 'title', 'totalTransaksi', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function cetakProses(Request $request)
    {
        // Ambil tanggal berikutnya (1 hari setelah hari ini)
        $tanggalBerikutnya = Carbon::now()->addDay()->format('Y-m-d');

        // Ambil transaksi yang memiliki tanggal acara pada tanggal berikutnya dan status 'SUCCESS' atau status lain yang Anda tentukan
        $transactions = Transaction::where('event_date', $tanggalBerikutnya)
            ->where(function ($query) {
                $query->where('status', 'SUCCESS')
                    ->orWhere('status', 'SHIPPING')
                    ->orWhere('status', 'FINISHED');
                // Tambahkan kondisi lain jika Anda ingin mencari status lainnya
                // Contoh: $query->orWhere('status', 'Dibatalkan');
            })
            ->get();

        $title = 'Transaksi Yang Akan Di Proses';
        $totalTransaksi = $transactions->sum('total_price');

        return view('pages.admin.transaction.laporan', compact('transactions', 'title', 'totalTransaksi'));
    }
}
