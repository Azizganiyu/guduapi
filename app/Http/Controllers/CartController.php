<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = auth()->user()->cart;
        return response()->json(['data' => $data, 'message' => 'Cart Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user_id = auth()->user()->id;

        Cart::updateOrCreate(
            ['user_id' => $user_id],
            ['cart' => $request->cart]
        );

        return response()->json(['message' => 'Cart successfully saved'], 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(){
        auth()->user()->cart->delete();
        return response()->json(['message' => 'Cart successfull deleted'], 200);
    }
}
