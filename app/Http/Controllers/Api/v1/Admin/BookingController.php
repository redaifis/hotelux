<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'invoice','room'])->orderByDesc('created_at')->paginate(10);
        return response()->json(compact('bookings'), 200);
    }

    public function totalBookings()
    {

        $days = [Carbon::today()->subDays(6)->format('M d') , Carbon::today()->subDays(5)->format('M d') , Carbon::today()->subDays(4)->format('M d') ,Carbon::today()->subDays(3)->format('M d') , Carbon::today()->subDays(2)->format('M d') , Carbon::today()->subDays(1)->format('M d') , Carbon::today()->format('M d')];

        $bookings = Booking::whereHas('invoice')->with('invoice')->whereBetween('created_at', [Carbon::today()->subDays(6), Carbon::today()->addDay()])->orderBy('created_at')->get()->groupBy(function ($item) {
            return $item->created_at->format('M d');
        })->toArray();

        // dd($days);

        foreach($days as $day){
            if(!Arr::exists($bookings, $day)){
                $bookings = Arr::add($bookings, $day, []);
            }
        }


        return response()->json(compact('bookings'), 200);
    }

    // public function revenue(){
    //     $days = [Carbon::today()->subDays(6)->format('M d') , Carbon::today()->subDays(5)->format('M d') , Carbon::today()->subDays(4)->format('M d') ,Carbon::today()->subDays(3)->format('M d') , Carbon::today()->subDays(2)->format('M d') , Carbon::today()->subDays(1)->format('M d') , Carbon::today()->format('M d')];

    //     $bookings = Booking::whereDate('created_at', '>=', Carbon::today()->subDays(6))->orderBy('created_at')->get()->groupBy(function ($item) {
    //         return $item->created_at->format('M d');
    //     })->toArray();

    //     // dd($days);

    //     foreach($days as $day){
    //         if(!Arr::exists($bookings, $day)){
    //             $bookings = Arr::add($bookings, $day, []);
    //         }
    //     }


    //     return response()->json(compact('bookings'), 200);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
