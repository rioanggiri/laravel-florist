<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::withCount(['products'])
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();
        //$categories = Category::take(6)->latest()->get();
        $products = Product::with(['galleries'])->take(8)->latest()->get();
        return view('pages.home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function guides()
    {
        return view('pages.guide');
    }
}
