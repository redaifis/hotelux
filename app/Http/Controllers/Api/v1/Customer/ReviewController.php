<?php

namespace App\Http\Controllers\Api\v1\Customer;

use App\Http\Controllers\Controller;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::with('room')->where('user_id', auth()->id())->orderByDesc('created_at')->paginate(8);
        return response(compact('reviews'),200);
    }

    public function show($id){
        $review = Review::where('id', $id)->first();
        return response(compact('review'),200);
    }


    public function update($id, Request $request){
        $review = Review::where('id', $id)->first();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
        return response(compact('review'),200);
    }

    public function destroy($id){
        $review = Review::findOrFail($id);
        $review->delete();
        return response('Review has been successfully deleted!', 200);
    }
}
