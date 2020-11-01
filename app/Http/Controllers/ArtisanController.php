<?php

namespace App\Http\Controllers;

use App\Http\Requests\createArtisan;
use App\Http\Requests\updateArtisan;
use App\Models\Artisan;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Artisan::with('job')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Artisans Retreived'], 200);
    }

    public function getArtisan(Artisan $artisan){
        if($artisan){
            return response()->json(['data' => $artisan, 'message' => 'Artisan Retreived'], 200);
        }
        else{
            return response()->json(['message' => 'Artisan not found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createArtisan $request)
    {
        $artisan = new Artisan;
        $artisan->user_id = auth()->user()->id;
        $artisan->first_name = $request->first_name;
        $artisan->last_name = $request->last_name;
        $artisan->job_id = $request->job_id;
        $artisan->username = $request->username;
        $artisan->email = $request->email;
        $artisan->gender = $request->gender;
        $artisan->image = $request->image;
        $artisan->phone = $request->phone;
        $artisan->phone_operator = $request->phone_operator;
        $artisan->city = $request->city;
        $artisan->address = $request->address;
        $artisan->about = $request->about;

        if(!$artisan->save()){
            return response()->json(['message' => 'Error Creating Artisan'], 500);
        }

        return response()->json(['message' => 'Artisan successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artisan  $artisan
     * @return \Illuminate\Http\Response
     */
    public function update(updateArtisan $request, Artisan $artisan)
    {
        $input = $request->all();
        $artisan->fill($input)->save();
        return response()->json(['message' => 'artisan successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artisan  $artisan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Artisan $artisan = null){
        if($artisan){
            $artisan->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $artisan = Artisan::find($id);
                $artisan->delete();
            }
        }
        return response()->json(['message' => 'Artisan(s) successfull deleted'], 200);
    }

    public function disable(Request $request, Artisan $artisan = null){

        if($artisan){
            $artisan->update(['status' => 0]);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $artisan = Artisan::find($id);
                $artisan->update(['status' => 0]);
            }
        }
        return response()->json(['message' => 'Artisan(s) successfull disabled'], 200);
    }

    public function enable(Request $request, Artisan $artisan = null){
        if($artisan){
            $artisan->update(['status' => 1]);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $artisan = Artisan::find($id);
                $artisan->update(['status' => 1]);
            }
        }
        return response()->json(['message' => 'Artisan(s) successfull enabled'], 200);
    }
}
