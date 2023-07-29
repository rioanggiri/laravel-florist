<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Review;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class DashboardTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions_data = Transaction::with(['user'])->where('users_id', Auth::user()->id)->get();
        // $transactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
        //     ->whereHas('transaction', function ($transaction) {
        //         $transaction->where('users_id', Auth::user()->id);
        //     })->get();

        return view('pages.dashboard-transaction', [
            'transactions' => $transactions_data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        if (request()->ajax()) {
            $query = TransactionDetail::with(['product.galleries'])->where('transactions_id', $transaction->id);

            return DataTables::of($query)
                ->addColumn('action', function ($item) use ($transaction) {
                    if ($transaction->status === 'FINISHED') {
                        $modalId = 'reviewModal-' . $item->product->id;

                        // Cek apakah pengguna sudah memberikan ulasan untuk produk ini
                        $hasReviewed = Review::where(
                            'users_id',
                            Auth::user()->id
                        )
                            ->where('products_id', $item->product->id)
                            ->where('transactions_id', $item->transaction->id)
                            ->exists();

                        if (!$hasReviewed) {
                            // Generate tombol "Beri Ulasan" jika belum memberikan ulasan
                            return '<button class="btn btn-store" data-toggle="modal" data-target="#' . $modalId . '">
                                        Beri Ulasan
                                    </button>';
                        } else {
                            // Tampilkan pesan atau teks lain jika sudah memberikan ulasan
                            return '<span class="text-success">Anda sudah memberikan ulasan</span>';
                        }
                    } else {
                        return '-';
                    }
                })
                ->editColumn('photos', function ($item) {
                    // Periksa apakah galeri ada sebelum mencoba mengakses properti photos
                    if (isset($item->product->galleries) && count($item->product->galleries) > 0) {
                        return '<img src="' . Storage::url($item->product->galleries->first()->photos) . '" style="max-height: 80px;" />';
                    } else {
                        // Anda bisa mengembalikan tampilan HTML dengan gambar placeholder atau ikon fotonya kosong
                        return '<img src="' . asset('images/placeholder.png') . '" style="max-height: 80px;" />';
                    }
                })
                ->editColumn('product.price', function ($item) {
                    return 'Rp. ' . number_format($item->product->price, 0, ',', '.');
                })
                ->rawColumns(['action', 'photos'])
                ->make(true);
        }

        $transaction_data = Transaction::with(['user'])
            ->where('users_id', Auth::user()->id)
            ->findOrFail($transaction->id);

        $detail_data = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->where('transactions_id', $transaction->id)->get();

        return view('pages.dashboard-transaction-details', [
            'transaction' => $transaction_data,
            'detail' => $detail_data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function invoice(Transaction $transaction)
    {
        $transaction_data = Transaction::with(['user'])
            ->where('users_id', Auth::user()->id)
            ->findOrFail($transaction->id);

        $detail_data = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->where('transactions_id', $transaction->id)->get();

        return view('pages.invoice', [
            'transaction' => $transaction_data,
            'details' => $detail_data,
        ]);
        // $pdf = new Dompdf();
        // // Render view Blade menjadi HTML menggunakan helper view()
        // $html = View::make('pages.invoice')->render();

        // $pdf->loadHtml($html);
        // $pdf->setPaper('A4', 'portrait'); // Atur ukuran kertas dan orientasi

        // $pdf->render();

        // return $pdf->stream('invoice.pdf');
    }
}
