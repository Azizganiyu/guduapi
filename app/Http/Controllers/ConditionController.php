<?php

namespace App\Http\Controllers;

use App\Http\Requests\createCondition;
use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Condition::withCount('products')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Conditions Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createCondition $request)
    {
        $condition = new Condition;
        $condition->name = $request->name;
        $condition->user_id = auth()->user()->id;

        if(!$condition->save()){
            return response()->json(['message' => 'Error Creating Condition'], 500);
        }

        return response()->json(['message' => 'Condition successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condition $condition)
    {
        $condition->update(['name' => $request->name]);
        return response()->json(['message' => 'condition successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Condition $condition = null){
        if($condition){
            $condition->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $condition = Condition::find($id);
                $condition->delete();
            }
        }
        return response()->json(['message' => 'Condition(s) successfull deleted'], 200);
    }
}
