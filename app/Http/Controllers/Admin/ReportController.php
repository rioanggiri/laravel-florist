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
    // public function laporan()
    // {
    //     $transactions = Transaction::all(); // Query sesuai kebutuhan laporan Anda

    //     $pdf = new Dompdf();
    //     // Render view Blade menjadi HTML menggunakan helper view()
    //     $html = View::make('pages.admin.transaction.laporan', compact('transactions'))->render();

    //     $pdf->loadHtml($html);
    //     $pdf->setPaper('A4', 'portrait'); // Atur ukuran kertas dan orientasi

    //     $pdf->render();

    //     return $pdf->stream('laporan-transaksi.pdf');

    //     // $pdf = PDF::loadView('pages.admin.transaksi-laporan', compact('transactions'));
    //     // return $pdf->stream('laporan-transaksi.pdf');
    // }
    public function cetakLaporan(Request $request)
    {
        $type = $request->type;

        // Cek tipe laporan, defaultnya seluruh transaksi
        if ($type === 'harian') {
            // Logika untuk laporan harian
            $transactions = Transaction::whereDate('created_at', today())->get();
            $title = 'Laporan Transaksi Harian';
        } elseif ($type === 'mingguan') {
            // Logika untuk laporan mingguan
            $transactions = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->get();
            $title = 'Laporan Transaksi Mingguan';
        } elseif ($type === 'bulanan') {
            // Logika untuk laporan bulanan
            $transactions = Transaction::whereMonth('created_at', now()->month)->get();
            $title = 'Laporan Transaksi Bulanan';
        } elseif ($type === 'akan-dikerjakan') {
            // Logika untuk laporan transaksi yang akan dikerjakan saat itu
            $transactions = Transaction::where('status', 'akan-dikerjakan')->get();
            $title = 'Laporan Transaksi Akan Dikerjakan';
        } else {
            // Logika untuk laporan seluruh transaksi
            $transactions = Transaction::all();
            $title = 'Laporan Seluruh Transaksi';
        }

        // Load view laporan dan passing data
        $pdf = PDF::loadView('pages.admin.transaction.laporan', compact('transactions', 'title'));

        // Atur header laporan
        $pdf->getDomPDF()->get_option('enable_html5_parser');
        $pdf->setPaper('A4', 'potrait');

        // Return laporan dalam bentuk PDF
        return $pdf->download('laporan-transaksi-' . now()->format('YmdHis') . '.pdf');
    }

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

        // Ambil transaksi yang memiliki tanggal acara pada tanggal berikutnya
        // $transactions = Transaction::where('event_date', $tanggalBerikutnya)
        //     ->get();

        $transactions = Transaction::where('status', 'SUCCESS')
            ->where(function ($query) use ($tanggalBerikutnya) {
                $query->where('event_date', $tanggalBerikutnya);
            })
            ->get();
        $title = 'Transaksi Yang Akan Di Proses';
        $totalTransaksi = $transactions->sum('total_price');

        return view('pages.admin.transaction.laporan', compact('transactions', 'title', 'totalTransaksi'));
    }
}
