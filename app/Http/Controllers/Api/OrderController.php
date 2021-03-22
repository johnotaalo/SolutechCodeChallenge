<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Order[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Order::with('products', 'products.suppliers')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_number'  =>  'required',
            'products'      =>  'required'
        ]);

        $order = Order::create([
            'order_number'  =>  $request->order_number
        ]);

        foreach ($request->products as $product){
            $order->productpivot()->create([
                'order_id'      =>  $order->id,
                'product_id'    =>  $product['value']
            ]);
        }

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return Order|Order[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return Order::with('products')->find($order->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return Order|\Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'order_number'  =>  'required',
            'products'      =>  'required'
        ]);

        $order->order_number = $request->order_number;

        $order->save();

        \App\Models\OrderDetail::where('order_id', $order->id)->forceDelete();

        foreach ($request->products as $product){
            $order->productpivot()->create([
                'order_id'      =>  $order->id,
                'product_id'    =>  $product['value']
            ]);
        }

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return array|\Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        return ['status' => $order->delete()];
    }
}
