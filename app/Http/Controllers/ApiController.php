<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function payment_handler(Request $request)
    {
        $json = json_decode($request->getContent());
        $signature_key = hash('sha256', $json->order_id . $json->status_code . $json->gross_amount .  env('MIDTRANS_CLIENT_KEY'));

        if ($signature_key != $json->signature_key) {
            return abort(404);
        }

        $transaction = Transaction::where('order_id', $json->order_id)->first();
        $transaction->update([
            'status' => $json->status_code,
        ]);
    }
}
