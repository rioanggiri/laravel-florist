<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaction::with(['user']);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    $isAdmin = Auth::user()->roles === 'ADMIN';
                    $actions = '<div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">';
                    // untuk admin
                    if ($isAdmin) {
                        $actions .= '<a class="dropdown-item" href="' . route('transaction.edit', $item->id) . '">
                                        Sunting
                                    </a>';
                    }
                    // Untuk admin dan owner
                    $actions .= '<a class="dropdown-item" href="' . route('transaction.show', $item->id) . '">
                                            Lihat
                                        </a>
                                        </div>
                                    </div>
                                </div>';
                    return $actions;
                })
                ->editColumn('status', function ($item) {
                    if ($item->status == 'PENDING') {
                        return 'PENDING';
                    } elseif ($item->status == 'SUCCESS') {
                        return 'SUKSES';
                    } elseif ($item->status == 'SHIPPING') {
                        return 'DALAM PENGIRIMAN';
                    } elseif ($item->status == 'FINISHED') {
                        return 'SELESAI';
                    } elseif ($item->status == 'CANCELLED') {
                        return 'BATAL';
                    }
                })
                ->editColumn('created_at', function ($item) {
                    return date('d-m-Y', strtotime($item->created_at));
                })
                ->editColumn('info', function ($item) {
                    return $item->info ?: '-';
                })
                ->rawColumns(['action', 'status'])
                ->make();
        }
        return view('pages.admin.transaction.index');
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
                ->editColumn('info', function ($item) {
                    return $item->info ?: '-';
                })
                ->rawColumns(['photos'])
                ->make(true);
        }

        $transaction_data = Transaction::with(['user'])
            ->findOrFail($transaction->id);

        $detail_data = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->where('transactions_id', $transaction->id)->get();

        return view('pages.admin.transaction.show', [
            'transaction' => $transaction_data,
            'detail' => $detail_data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Transaction::findOrFail($id);

        return view('pages.admin.transaction.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        // Jika status bukan CANCELLED, kosongkan info
        if ($data['status'] !== 'CANCELLED') {
            $data['info'] = null;
        }

        $item = Transaction::findOrFail($id);

        $item->update($data);

        return redirect()->route('transaction.index');
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
