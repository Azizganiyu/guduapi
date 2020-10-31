<?php

namespace App\Http\Controllers;

use App\Http\Requests\createProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('category', 'modell', 'make','part', 'condition', 'part')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Products Retreived'], 200);
    }

    public function getProduct(Product $product){
        if($product){
            return response()->json(['data' => $product, 'message' => 'Product Retreived'], 200);
        }
        else{
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createProduct $request)
    {
        $product = new Product;
        $product->user_id = auth()->user()->id;
        $product->name = $request->name;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->friendly_url = $request->friendly_url;
        $product->height = $request->height;
        $product->width = $request->width;
        $product->depth = $request->depth;
        $product->weight = $request->weight;
        $product->category_id = $request->category_id;
        $product->condition_id = $request->condition_id;
        $product->make_id = $request->make_id;
        $product->part_id = $request->part_id;
        $product->modell_id = $request->modell_id;
        $product->vin_tag = $request->vin_tag;
        $product->images = $request->images;
        $product->quantity = $request->quantity;

        if(!$product->save()){
            return response()->json(['message' => 'Error Creating Product'], 500);
        }

        return response()->json(['message' => 'Product successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $product->fill($input)->save();
        return response()->json(['message' => 'product successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product = null){
        if($product){
            $product->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $product = Product::find($id);
                $product->delete();
            }
        }
        return response()->json(['message' => 'Product(s) successfull deleted'], 200);
    }

    public function disable(Request $request, Product $product = null){
        if($product){
            $product->update(['status' => 0]);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $product = Product::find($id);
                $product->update(['status' => 0]);
            }
        }
        return response()->json(['message' => 'Product(s) successfull disabled'], 200);
    }

    public function enable(Request $request, Product $product = null){
        if($product){
            $product->update(['status' => 1]);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $product = Product::find($id);
                $product->update(['status' => 1]);
            }
        }
        return response()->json(['message' => 'Product(s) successfull enabled'], 200);
    }
}
