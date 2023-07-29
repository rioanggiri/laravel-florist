<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries'])->where('slug', $id)->firstOrFail();
        // Menggunakan Eloquent untuk mengambil data review dan meng-load relasi terkait
        $reviews = Review::with(['product.galleries', 'user'])
            ->whereHas('product', function ($query) use ($id) {
                $query->where('slug', $id);
            })
            ->get();

        // $reviews akan berisi data review yang terkait dengan produk yang memiliki slug yang sesuai
        //dd($reviews);
        return view('pages.detail', [
            'product' => $product,
            'reviews' => $reviews
        ]);
    }

    public function add(Request $request, $id)
    {
        $data = [
            'products_id' => $id,
            'users_id' => Auth::user()->id,
        ];
        Cart::create($data);

        return redirect()->route('cart');
    }
}
