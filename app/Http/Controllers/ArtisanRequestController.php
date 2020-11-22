<?php

namespace App\Http\Controllers;

use App\Http\Requests\createArtisanRequest;
use App\Models\ArtisanRequest;
use Illuminate\Http\Request;

class ArtisanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ArtisanRequest::with('user', 'job')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Artisans requests Retreived'], 200);
    }

    public function getArtisanRequest(ArtisanRequest $artisan_request){
        if($artisan_request){
            return response()->json(['data' => $artisan_request, 'message' => 'Artisan request Retreived'], 200);
        }
        else{
            return response()->json(['message' => 'Artisan request not found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createArtisanRequest $request)
    {
        $artisan_request = new ArtisanRequest;
        $artisan_request->user_id = auth()->user()->id;
        $artisan_request->job_id = $request->job_id;
        $artisan_request->description = $request->description;
        $artisan_request->phone = $request->phone;
        $artisan_request->address = $request->address;
        $artisan_request->landmark = $request->landmark;
        $artisan_request->state = $request->state;
        $artisan_request->city = $request->city;
        $artisan_request->status = 'pending';

        if(!$artisan_request->save()){
            return response()->json(['message' => 'Error sending request'], 500);
        }

        return response()->json(['message' => 'Artisan request sent successfully'], 201);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\ArtisanRequest  $artisan_request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(updateArtisan $request, ArtisanRequest $artisan_request)
    // {
    //     $input = $request->all();
    //     $artisan_request->fill($input)->save();
    //     return response()->json(['message' => 'artisan successfully updated'], 200);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArtisanRequest  $artisan_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ArtisanRequest $artisan_request = null){
        if($artisan_request){
            $artisan_request->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $artisan_request = ArtisanRequest::find($id);
                $artisan_request->delete();
            }
        }
        return response()->json(['message' => 'ArtisanRequest(s) successfully deleted'], 200);
    }

    public function decline(Request $request, ArtisanRequest $artisan_request = null){

        if($artisan_request){
            $artisan_request->update(['status' => 'declined']);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $artisan_request = ArtisanRequest::find($id);
                $artisan_request->update(['status' => 'declined']);
            }
        }
        return response()->json(['message' => 'ArtisanRequest(s) successfully declined'], 200);
    }

    // public function enable(Request $request, ArtisanRequest $artisan_request = null){
    //     if($artisan_request){
    //         $artisan_request->update(['status' => 1]);
    //     }
    //     elseif($request->ids){
    //         foreach($request->ids as $id){
    //             $artisan_request = ArtisanRequest::find($id);
    //             $artisan_request->update(['status' => 1]);
    //         }
    //     }
    //     return response()->json(['message' => 'ArtisanRequest(s) successfull enabled'], 200);
    // }
}
