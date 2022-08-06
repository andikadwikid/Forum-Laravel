<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Premium;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use App\Services\Midtrans\CreateSnapTokenService;

class MidtransController extends Controller
{

    public function index(Request $request)
    {

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');

        \Midtrans\Config::$isProduction = false;

        \Midtrans\Config::$isSanitized = false;

        \Midtrans\Config::$is3ds = false;

        $premium = Premium::where('id', 1)->first();

        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $premium->price,
            ],
            'items_details' => [
                [
                    'id' => $premium->id,
                    'price' => $premium->price,
                    'quantity' => 1,
                    'name' => $premium->title,
                ],
            ],
            'customer_details' => [
                'first_name' => auth()->user()->firstname,
                'last_name' => auth()->user()->lastname,
                'email' => auth()->user()->email,
                // 'phone' => '08111222333',
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // dd($snapToken);
        return view('subscribe.index', compact('snapToken'));
    }

    public function store(Request $request)
    {
        $premium = Premium::first();

        $json = json_decode($request->get('json'));
        $transaction = new Transaction();
        $transaction->user_id = auth()->user()->id;
        $transaction->premium_id = $premium->id;
        $transaction->transaction_id = $json->transaction_id;
        $transaction->gross_amount = $json->gross_amount;
        $transaction->transaction_status = $json->transaction_status;
        $transaction->order_id = $json->order_id;
        $transaction->payment_type = $json->payment_type;
        $transaction->payment_code = isset($json->payment_code) ?? null;
        $transaction->transaction_time = $json->transaction_time;
        $transaction->pdf_url = isset($json->pdf_url) ?? null;
        $success = $transaction->save();
        if ($success) {
            return to_route('home.index')->with('success', 'Transaction Success');
        }
        // dd($json);
        // dd($json->va_numbers[0]->bank);
    }
}
