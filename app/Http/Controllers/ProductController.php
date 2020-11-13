<?php

namespace App\Http\Controllers;

use App\Http\Requests\createProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('category', 'modell', 'year', 'make','part', 'condition', 'part')->paginate(20);
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
        $product->year_id = $request->year_id;
        $product->vin_tag = $request->vin_tag;
        $product->part_number = $request->part_number;
        $product->images = $request->images;
        $product->quantity = $request->quantity;
        $product->rating = 0;

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
        $product->year_id = $request->year_id;
        $product->vin_tag = $request->vin_tag;
        $product->part_number = $request->part_number;
        $product->images = $request->images;
        $product->quantity = $request->quantity;

        $product->save();
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

    public function trending(Category $category){
        $products = $category->products()->limit(4)->orderBy('id', 'desc')->get();
        return response()->json(['data' => $products,'message' => 'Product(s) successfull retreived'], 200);
    }

    public function hotDeals(){
        $products = Product::limit(2)->get();
        return response()->json(['data' => $products,'message' => 'Product(s) successfull retreived'], 200);
    }

    public function getProductByUrl($url){
        $data = Product::where('friendly_url', $url)
        ->with('category', 'modell', 'year', 'make','part', 'condition', 'part')
        ->first();
        if($data){
            return response()->json(['data' => $data,'message' => 'Product successfull retreived'], 200);
        }
        else{
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function getCategoryProducts(Category $category){
        $products = $category->products()->orderBy('id', 'desc')->paginate(20);
        return response()->json(['data' => $products,'message' => 'Product(s) successfull retreived'], 200);
    }

    public function getProductsListings(Request $request){

        $vin_number = trim($request->vin_number);
        $part_number = trim($request->part_number);

        $data_len = 0;
        $data = null;

        if(strlen($request->vin_number) > 0){
            $data = product::where('vin_tag', $request->vin_number);
            $data_len = $data->count();
        }
        if($data_len === 0 && strlen($request->part_number) > 0){
            $data = product::where('part_number', $request->part_number);
            $data_len = $data->count();
        }
        if($data_len === 0 && $request->year){
            $data = product::where('year_id', $request->year);
            $data_len = $data->count();
        }
        if($data_len === 0 && $request->model){
            $data = product::where('modell_id', $request->model);
            $data_len = $data->count();
        }
        if($data_len === 0 && $request->make){
            $data = product::where('make_id', $request->make);
            $data_len = $data->count();
        }
        if($data_len === 0 && $request->category){
            $data = product::where('category_id', $request->category);
            $data_len = $data->count();
        }
        if($data_len > 0){
            if($request->part){
                $part = $data->where('part_id', $request->part);
                if($part->count() > 0){

                    if($request->condition){
                        $condition = $part->where('condition_id', $request->condition);

                        if($condition->count() > 0){
                            return response()->json(['data' => $condition->paginate(20), 'message' => 'Product Retreived'], 200);
                        }
                        else{
                            return response()->json(['data' => $part->paginate(20), 'message' => 'Product Retreived'], 200);
                        }
                    }
                    else{
                        return response()->json(['data' => $part->paginate(20), 'message' => 'Product Retreived'], 200);
                    }
                }
                else{
                    return response()->json(['data' => $data->paginate(20), 'message' => 'Product Retreived'], 200);
                }
            }
            if($request->condition){
                $condition = $data->where('condition_id', $request->condition);

                if($condition->count() > 0){
                    return response()->json(['data' => $condition->paginate(20), 'message' => 'Product Retreived'], 200);
                }
                else{
                    return response()->json(['data' => $data->paginate(20), 'message' => 'Product 5 Retreived'], 200);
                }
            }

            return response()->json(['data' => $data->paginate(20), 'message' => 'Product Retreived'], 200);
        }
        else{
            return response()->json(['message' => 'Product not found'], 404);
        }

    }

    public function getRelatedProducts(Request $request){

        $data_len = 0;
        $data = null;


        if($data_len === 0 && $request->model){
            $data = product::where('modell_id', $request->model)->where('id', '<>', $request->id);
            $data_len = $data->count();
        }
        if($data_len === 0 && $request->make){
            $data = product::where('make_id', $request->make)->where('id', '<>', $request->id);
            $data_len = $data->count();
        }
        if($data_len === 0 && $request->category){
            $data = product::where('category_id', $request->category)->where('id', '<>', $request->id);
            $data_len = $data->count();
        }
        if($data_len > 0){
            if($request->part){
                $part = clone $data;
                $part->where('part_id', $request->part);
                if($part->count() > 0){

                    return response()->json(['data' => $part->limit(4)->get(), 'message' => 'Product Retreived'], 200);

                }
                else{
                    return response()->json(['data' => $data->limit(4)->get(), 'message' => 'Product Retreived'], 200);
                }
            }
            return response()->json(['data' => $data->limit(4)->get(), 'message' => 'Product Retreived'], 200);
        }
        else{
            return response()->json(['data' => $request->all(), 'message' => 'Product not found'], 404);
        }

    }

}
