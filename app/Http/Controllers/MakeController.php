<?php

namespace App\Http\Controllers;

use App\Http\Requests\createMake;
use App\Models\Make;
use Illuminate\Http\Request;

class MakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Make::withCount('products')->with('category')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'makes Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createMake $request)
    {
        $make = new Make;
        $make->name = $request->name;
        $make->user_id = auth()->user()->id;
        $make->category_id = $request->category_id;

        if(!$make->save()){
            return response()->json(['message' => 'Error Creating Make'], 500);
        }

        return response()->json(['message' => 'Make successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Make  $make
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Make $make)
    {
        $make->update(
            ['name' => $request->name, 'category_id' => $request->category_id]
        );
        return response()->json(['message' => 'make successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Make  $make
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Make $make = null){
        if($make){
            $make->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $make = Make::find($id);
                $make->delete();
            }
        }
        return response()->json(['message' => 'Make(s) successfull deleted'], 200);
    }
}
