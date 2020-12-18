<?php

namespace App\Http\Controllers;

use App\Http\Requests\createReview;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Review::with('user')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Reviews Retreived'], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createReview $request)
    {
        $review = new Review;
        $review->comments = $request->comments;
        $review->rating = $request->rating;
        $review->product_id = $request->product_id;
        $review->user_id = auth()->user()->id;

        if(!$review->save()){
            return response()->json(['message' => 'Error Creating Review'], 500);
        }

        return response()->json(['message' => 'Thanks for reviewing this product'], 201);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Review  $review
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, Review $review)
    {
        $review->update([
            'comments' => $request->comments,
            'rating' => $request->rating,
            ]);
        return response()->json(['message' => 'review successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review){
        $review->delete();
        return response()->json(['message' => 'Review successfull deleted'], 200);
    }

    public function checkReviewed($product_id){
        $review = Review::where('product_id', $product_id)->where('user_id', auth()->user()->id)->get();
        if($review->count() > 0){
            return response()->json(['message' => 'Reviewed', 'reviewed' => 1], 200);
        }
        else{
            return response()->json(['message' => 'Not reviewed', 'reviewed' => 0], 200);
        }
    }

    public function getProductReviews($product_id){
        $review = Review::where('product_id', $product_id)->with('user')->paginate(10);
        return response()->json(['message' => 'Reviewed', 'data' => $review], 200);
    }

    public function getUserReviews(){
        $review = auth()->user()->reviews()->with('product')->paginate(10);
        return response()->json(['message' => 'Reviews retrieved', 'data' => $review], 200);
    }
}
