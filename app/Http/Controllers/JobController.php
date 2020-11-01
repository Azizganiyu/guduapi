<?php

namespace App\Http\Controllers;

use App\Http\Requests\createJob;
use App\Models\job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = job::withCount('artisans')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Jobs Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createJob $request)
    {
        $job = new job;
        $job->name = $request->name;
        $job->user_id = auth()->user()->id;

        if(!$job->save()){
            return response()->json(['message' => 'Error Creating Job'], 500);
        }

        return response()->json(['message' => 'Job successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, job $job)
    {
        $job->update(['name' => $request->name]);
        return response()->json(['message' => 'Job successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, job $job = null){
        if($job){
            $job->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $job = job::find($id);
                $job->delete();
            }
        }
        return response()->json(['message' => 'Job(s) successfull deleted'], 200);
    }
}
