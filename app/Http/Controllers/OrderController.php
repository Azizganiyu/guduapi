<?php

namespace App\Http\Controllers;

use App\Http\Requests\createOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::with('user')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Orders Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createOrder $request)
    {
        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->address = $request->address;
        $order->state = $request->state;
        $order->city = $request->city;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->phone = $request->phone;
        $order->cart = $request->cart;
        $order->delivery_fee = $request->delivery_fee;
        $order->delivery_type = $request->delivery_type;
        $order->total_price = $request->total_price;
        $order->delivery_time_min = $request->delivery_time_min;
        $order->delivery_time_max = $request->delivery_time_max;
        $order->payment_type = $request->payment_type;
        $order->payment_status = $request->payment_status;
        $order->delivery_status = 'pending';
        $order->order_status = 'pending';
        $order->order_code = $request->order_code;

        if(!$order->save()){
            return response()->json(['message' => 'Error Creating Order'], 500);
        }

        return response()->json(['code' => $request->order_code, 'message' => 'Order successfully created'], 201);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Order  $order
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Order $order)
    // {
    //     $order->update(['name' => $request->name]);
    //     return response()->json(['message' => 'order successfully updated'], 200);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Order $order = null){
        if($order){
            $order->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $order = Order::find($id);
                $order->delete();
            }
        }
        return response()->json(['message' => 'Order(s) successfull deleted'], 200);
    }

    public function decline(Request $request, Order $order = null){

        if($order){
            $order->update(['order_status' => 'declined']);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $order = Order::find($id);
                $order->update(['order_status' => 'declined']);
            }
        }
        return response()->json(['message' => 'Order(s) successfully declined'], 200);
    }

    public function getOrderByCode($order_code){
        $data = Order::where('order_code', $order_code)->with('user')->first();

        if($data){
           return response()->json(['data' => $data, 'message' => 'Order Retreived'], 200);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }
}
