<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('orders', 'suppliers')->get();
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
            'name'          =>  'required',
            'quantity'      =>  'required|min:1',
            'description'   =>  'required',
            'supplier'      =>  'required'
        ]);

        $product = Product::create([
            'name'          =>  $request->name,
            'quantity'      =>  $request->quantity,
            'description'   =>  $request->description
        ]);

        foreach($request->supplier as $supply){
            $product->supplierpivot()->create([
                'product_id'        =>  $product->id,
                'supply_id'         =>  $supply['id']
            ]);
        }

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return Product|\Illuminate\Database\Eloquent\Builder|\Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Product::with('suppliers')->find($product->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return Product
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name'          =>  'required',
            'quantity'      =>  'required|min:1',
            'description'   =>  'required',
            'supplier'      =>  'required'
        ]);

        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->description = $request->description;

        $product->save();

        \App\Models\SupplierProduct::where('product_id', $product->id)->forceDelete();

        foreach($request->supplier as $supply){
            $product->supplierpivot()->create([
                'product_id'        =>  $product->id,
                'supply_id'         =>  $supply['id']
            ]);
        }

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function destroy(Product $product)
    {
        return ['status' => $product->delete()];
    }
}
