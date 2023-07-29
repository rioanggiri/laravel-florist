<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Review::with(['product.galleries', 'transaction']);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    // return '<span class="text-success">Sudah Disunting</span>';
                    //Jika Menghapus Pakai Dibawah
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <form action="' . route('admin-delete-review', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
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
        return view('pages.admin.review.index');
    }

    public function delete(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('admin-review');
    }
}
