<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{

    /**
     * Create a new ReviewController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','roomReviews','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reviews = Review::orderByDesc('created_at')->with('user')->limit(5)->get();
        return response()->json(compact('reviews'),200);

    }

    public function roomReviews($room_id){
        $reviews = Review::where('room_id', $room_id)->where('is_approved', 1)->orderByDesc('created_at')->with('user')->paginate(5);
        return response()->json(compact('reviews'),200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $review = new Review;
        $review->user_id = Auth::id();
        $review->room_id = $request->roomId;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response()->json(['review' => $review, 'message' => 'Review has been successfuly created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        $review->destroy();
        return response()->json(['message' => 'Review has been successfuly deleted!']);
    }
}
