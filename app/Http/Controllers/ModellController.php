<?php

namespace App\Http\Controllers;

use App\Http\Requests\createModel;
use App\Models\Modell;
use Illuminate\Http\Request;

class ModellController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Modell::withCount('products')->with('category', 'make')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Models Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createModel $request)
    {
        $modell = new Modell;
        $modell->name = $request->name;
        $modell->user_id = auth()->user()->id;
        $modell->category_id = $request->category_id;
        $modell->make_id = $request->make_id;

        if(!$modell->save()){
            return response()->json(['message' => 'Error Creating Model'], 500);
        }

        return response()->json(['message' => 'Model successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modell  $modell
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modell $model)
    {
        $model->update(
            [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'make_id' => $request->make_id
                ]
        );
        return response()->json(['message' => 'model successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modell  $modell
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Modell $model = null){
        if($model){
            $model->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $modell = Modell::find($id);
                $modell->delete();
            }
        }
        return response()->json(['message' => 'Model(s) successfull deleted'], 200);
    }
}
