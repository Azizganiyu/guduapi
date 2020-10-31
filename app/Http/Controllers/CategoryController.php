<?php

namespace App\Http\Controllers;

use App\Http\Requests\createCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::paginate(20);
        return response()->json(['data' => $data, 'message' => 'Categories Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createCategory $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->user_id = auth()->user()->id;

        if(!$category->save()){
            return response()->json(['message' => 'Error Creating Category'], 500);
        }

        return response()->json(['message' => 'Category successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->update(['name' => $request->name]);
        return response()->json(['message' => 'category successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category = null){
        if($category){
            $category->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $category = Category::find($id);
                $category->delete();
            }
        }
        return response()->json(['message' => 'Category(ies) successfull deleted'], 200);
    }
}
