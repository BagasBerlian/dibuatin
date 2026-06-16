<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Midtrans\Transaction as MidtransTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Mendapatkan data order dari database
        $order_id = session('order_id');
        $order = Order::where('id', $order_id)->first();
        // Parameter yang dikirim ke Midtrans
        $params = [
                'transaction_details' => [
                        'order_id' => $order->id,
                        'gross_amount' => $order->price,],
                'customer_details' => [
                        'first_name' => $order->user->name,
                        'email' => $order->user->email,
                        'phone' => $order->user->phone,],
                'item_details' => [
                    [
                        'id' => $order->package->product_id,
                        'price' => $order->package->price,
                        'quantity' => 1,
                        'name' => $order->package->product->name . ' (' . $order->package->name . ')',],

                    ]
        ];
        


        try {
            // Mendapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            
            // Menampilkan halaman checkout dengan Snap Token
            return view('payment', compact('snapToken', 'order'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }       
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|string',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string',
            'transaction_status' => 'required|string',
        ]);
        $data = Transaction::create([
            'order_id' => $validated['order_id'],
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'],
            'payment_status' => $validated['transaction_status'],
        ]);
        return response()->json([
            'message' => 'Data stored successfully',
            'data' => $data,
        ]);
    }

    public function resumePayment(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)
                    ->where('user_id', Auth::user()->id)
                    ->first();

        if (!$order) {
            return redirect()->route('history.show')->with('error', 'Order tidak ditemukan.');
        }

        session()->put('order_id', $order->id);
        return redirect()->route('payment');
    }
}
