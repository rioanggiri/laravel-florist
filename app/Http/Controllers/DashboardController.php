<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions_data = Transaction::with(['user'])->where('users_id', Auth::user()->id)->get();
        return view('pages.dashboard', [
            'transaction_data' => $transactions_data,
        ]);
    }
}
