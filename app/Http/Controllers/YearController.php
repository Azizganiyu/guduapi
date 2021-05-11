<?php

namespace App\Http\Controllers;

use App\Http\Requests\createYear;
use App\Models\Modell;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{ /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $data = Year::withCount('products')->with('category', 'make', 'modell')->paginate(20);
       return response()->json(['data' => $data, 'message' => 'Years Retreived'], 200);
   }

   public function getByModel($model){
    $data = Year::where('modell_id', $model)->get();
    return response()->json(['data' => $data, 'message' => 'Years Retreived'], 200);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(createYear $request)
   {
       $year = new Year;
       $year->name = $request->name;
       $year->user_id = auth()->user()->id;
       $year->category_id = $request->category_id;
       $year->make_id = $request->make_id;
       $year->modell_id = $request->modell_id;
       $year->year = $request->year;

       if(!$year->save()){
           return response()->json(['message' => 'Error Creating Year'], 500);
       }

       return response()->json(['message' => 'Year successfully created'], 201);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Years\Year  $year
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Year $year)
   {
       $year->update(
           [
               'name' => $request->name,
               'category_id' => $request->category_id,
               'make_id' => $request->make_id,
               'modell_id' => $request->modell_id,
               'year' => $request->year
               ]
       );
       return response()->json(['message' => 'year successfully updated'], 200);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Years\Year  $year
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, Year $year = null){
       if($year){
           $year->delete();
       }
       elseif($request->ids){
           foreach($request->ids as $id){
               $year = Year::find($id);
               $year->delete();
           }
       }
       return response()->json(['message' => 'Year(s) successfull deleted'], 200);
   }

   public function getGroupedYears($model){
    //$data = Year::get()->groupBy('year');
    $modell = Modell::find($model);
    if($modell){
        $data = $model->years()->get()->groupBy('year');
        return response()->json(['data' => $data, 'message' => 'Years Retreived'], 200);
    }
    else{
      return response()->json(['data' => '{}', 'message' => 'Years Retreived'], 200);
    }
   }

//    public function index()
//     {
//         $data =  auth()->user()->staffAccount->vendor->incomes()->get()->groupBy('year');
//         return response()->json(['data' => $data, 'message' => 'retreived'], 200);
//     }
}
