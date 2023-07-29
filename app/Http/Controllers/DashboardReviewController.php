<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DashboardReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Review::with(['product.galleries', 'transaction'])->where('users_id', Auth::user()->id);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    // Cek apakah pengguna sudah mengedit ulasan sebelumnya
                    $isEditable = $item->is_editable; // Gantikan dengan logika pengambilan status pengeditan ulasan
                    // Jika pengguna belum mengedit ulasan, tampilkan tombol "Sunting"
                    if ($isEditable) {
                        return '
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . route('reviews.edit', $item->id) . '">
                                            Sunting
                                        </a>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                    // Jika pengguna sudah mengedit ulasan sebelumnya, tampilkan teks "Sudah Disunting"
                    return '<span class="text-success">Sudah Disunting</span>';
                    //Jika Menghapus Pakai Dibawah
                    // <form action="' . route('product-gallery.destroy', $item->id) . '" method="POST">
                    //     ' . method_field('delete') . csrf_field() . '
                    //     <button type="submit" class="dropdown-item text-danger">
                    //         Hapus
                    //     </button>
                    // </form>
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
                ->editColumn('rating', function ($item) {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $item->rating) {
                            $stars .= '<span class="star">&#9733;</span>'; // Bintang terisi (karakter Unicode U+2605)
                        } else {
                            $stars .= '<span class="star">&#9734;</span>'; // Bintang kosong (karakter Unicode U+2606)
                        }
                    }
                    return $stars;
                })
                ->rawColumns(['action', 'photos', 'rating'])
                ->make();
        }
        return view('pages.dashboard-review');
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
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'transaction_id' => 'required|exists:transactions,id', // Tambahkan validasi untuk transaction_id
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // dd($data);
        Review::create([
            'users_id' => Auth::user()->id,
            'products_id' => $request->product_id,
            'transactions_id' => $request->transaction_id, // Simpan transaction_id ke dalam tabel reviews
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Review::with(['product.galleries', 'transaction'])->findOrFail($id);
        return view('pages.dashboard-review-edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input yang dikirimkan dari formulir edit
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        // Cari ulasan berdasarkan ID
        $review = Review::find($id);

        // Cek apakah ulasan ditemukan
        if (!$review) {
            return redirect()->route('reviews.index')->with('error', 'Ulasan tidak ditemukan.');
        }

        // Cek apakah pengguna memiliki akses untuk mengedit ulasan
        // Anda bisa menambahkan logika berdasarkan kolom is_editable atau mengatur batasan lain sesuai kebutuhan
        // Contoh: if (!$review->is_editable) { return redirect()->route('reviews.index')->with('error', 'Anda tidak dapat mengedit ulasan ini.'); }

        // Update nilai rating dan komentar ulasan
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->is_editable = false;

        // Simpan perubahan ulasan ke dalam penyimpanan data
        $review->save();

        // Redirect pengguna kembali ke halaman daftar ulasan dengan pesan sukses
        return redirect()->route('reviews.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
