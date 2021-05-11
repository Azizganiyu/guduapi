<?php

namespace App\Http\Controllers;

use App\Http\Requests\createPart;
use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Part::withCount('products')->with('category')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Parts Retreived'], 200);
    }

    public function getByCategory($category)
    {
        $data = Part::where('category_id', $category)->get();
        return response()->json(['data' => $data, 'message' => 'Parts Retreived'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createPart $request)
    {
        $part = new Part;
        $part->name = $request->name;
        $part->user_id = auth()->user()->id;
        $part->category_id = $request->category_id;

        if(!$part->save()){
            return response()->json(['message' => 'Error Creating Part'], 500);
        }

        return response()->json(['message' => 'Part successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        $part->update(
            ['name' => $request->name, 'category_id' => $request->category_id]
        );
        return response()->json(['message' => 'part successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Part $part = null){
        if($part){
            $part->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $part = Part::find($id);
                $part->delete();
            }
        }
        return response()->json(['message' => 'Part(ies) successfull deleted'], 200);
    }
}
