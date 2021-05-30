<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function flutterPay(Request $request){

        $data = [
            "tx_ref" => md5(rand(0, 1000)),
            "amount" => $request->amount,
            "currency" => "NGN",
            "redirect_url" => "https://api.gudumarketonline.com/payment/flutter_confirm",
            "payment_options" => "card",
            "meta" => [
                "customer_id" => auth()->user()->id,
            ],
            "customer" => [
                "id" => auth()->user()->id,
                "email" => auth()->user()->email,
                "name" => auth()->user()->first_name.' '.auth()->user()->last_name
            ],
            "customizations" => [
                "title" => "Gudu market",
                "description" => "Service Pay",
                "logo" => "https://gudumarketonline.com/assets/images/logo.png"
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer FLWSECK_TEST-SANDBOXDEMOKEY-X',
        ])->post('https://api.flutterwave.com/v3/payments', $data);

        if($response->ok()){
            return response()->json(['message' => 'Flutter link created', 'status' => true, 'data' => $response->json()], 200);
        }
        else{
            return response()->json(['message' => 'Error creating payment link', 'status' => false], 400);
        }
    }

    public function verifyFlutterPay($ref){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer FLWSECK_TEST-SANDBOXDEMOKEY-X',
        ])->get('https://api.flutterwave.com/v3/transactions/'.$ref.'/verify');

        if($response->ok()){
            return response()->json(['message' => 'Transaction verification status', 'status' => true, 'data' => $response->json()], 200);
        }
        else{
            return response()->json(['message' => 'Transaction verification status', 'data' => $response->json(), 'status' => false], 400);
        }
    }
}
