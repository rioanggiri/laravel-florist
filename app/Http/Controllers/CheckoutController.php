<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(CheckoutRequest $request)
    {
        // Request All Data Checkout
        $data = $request->all();

        // Process Checkout
        $code = 'WFL-' . mt_rand(000000, 999999);
        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        // Add to Transaction data
        $data['code'] = $code;
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = (int) $request->total_price;
        $data['status'] = 'PENDING';

        // Create Transaction
        $transaction = Transaction::create($data);

        // Transaction Detail Create
        foreach ($carts as $cart) {
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => (int) $cart->product->price,
            ]);
        }

        // Delete Cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        // Configuration of Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Setup midtrans variable
        $midtrans = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => (int) $transaction->total_price,
            ],
            'customer_details' => [
                'first_name'    => $transaction->name,
                'email'         => Auth::user()->email,
                'phone'         => $transaction->phone,
            ],
            'enabled_payments' => [
                'credit_card', 'gopay', 'permata_va', 'bank_transfer'
            ],
            'vtweb' => [],
        ];

        // Get Redirection URL of a Payment Page
        try {
            // Get Snap Payment Page URL
            // Pemberian Snap Token melalui SNAP API Dari Midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function callback(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance Midtrans Notification
        $notification = new Notification();

        // Ambil data dari notifikasi
        $status = $notification->transaction_status;
        $fraud = $notification->fraud_status;
        $orderId = $notification->order_id;

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::with(['user'])->where('code', $orderId)->first();

        if (!$transaction) {
            // Jika transaksi tidak ditemukan
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'message' => 'Transaction not found'
                ]
            ]);
        }

        // Handle status pembayaran
        if ($status == 'capture') {
            if ($fraud == 'challenge') {
                $transaction->status = 'PENDING';
            } else {
                $transaction->status = 'SUCCESS';
            }
        } elseif ($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        } elseif ($status == 'pending') {
            $transaction->status = 'PENDING';
        } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
            $transaction->status = 'CANCELLED';
        }

        // Simpan perubahan pada transaksi
        $transaction->save();

        // Kirimkan respon sesuai dengan status pembayaran
        if ($transaction->status == 'SUCCESS') {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Transaction is successful'
                ]
            ]);
        } elseif ($transaction->status == 'PENDING') {
            // Jika pembayaran masih dalam proses verifikasi

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Transaction is pending'
                ]
            ]);
        } else {
            // Jika pembayaran gagal atau dibatalkan

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Transaction is cancelled'
                ]
            ]);
        }
    }
}
