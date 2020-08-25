<?php

namespace App\Http\Controllers;

use App\Article;
use App\Booking;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    public function landingPage(){
        return view('app.LandingPage');
    }

    public function login(){
        return view('app.auth.login');
    }

    public function register(){
        return view('app.auth.register');
    }

    public function searchRooms(Request $request){
        $checkin = null;
        $checkout = null;
        $guests = null;

        if($request->has('checkin') && $request->has('checkout') && $request->has('guests')){
            $checkin = $request->checkin;
            $checkout = $request->checkout;
            $guests = $request->guests;


        }

        return view('app.RoomsList',compact(['checkin', 'checkout', 'guests']));
    }

    public function showRoom($id){
        $roomId = Room::where('slug', $id)->first();
        return view('app.RoomPage', ['roomId' => $roomId->id]);
    }

    public function blog($id){
        $article = Article::findOrFail($id);
        return view('app.ArticlePage', ['articleId' => $article->id]);
    }



}
