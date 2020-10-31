<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
Use Image;
use Intervention\Image\Exception\NotReadableException;

class GalleryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Gallery::orderBy('id', 'desc')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Gallery Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->hasFile('image')) {
            return response()->json(['message' => 'Image not found'], 400);
        }

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        $gallery = new Gallery;
        $gallery->user_id = auth()->user()->id;
        $gallery->name = $imageName;

        if(!$gallery->save()){
            return response()->json(['message' => 'Error uploading image'], 500);
        }

        return response()->json(['message' => 'Image successfully uploaded'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Gallery $gallery){

        if($this->delete_image($gallery->name)){
            $gallery->delete();
            return response()->json(['message' => 'Image successfull deleted'], 200);
        }


        return response()->json(['message' => 'Unable to delete image'], 500);
    }


    public function delete_image($image_name)
    {
        if(file_exists(public_path('images/'.$image_name))){

           if(unlink(public_path('images/'.$image_name))){
                return true;
           }
           else{
               return false;
           }

        }
        else{
            return false;
        }


    }
}
