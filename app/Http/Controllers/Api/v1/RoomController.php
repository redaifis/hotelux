<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->recommanded){
            $rooms = Room::orderByDesc('created_at')->recommanded()->limit(6)->get();
            return response()->json(compact('rooms'), 200);
        }
        $rooms = Room::orderByDesc('created_at')->limit(6)->get();
        return response()->json(compact('rooms'), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::with('bookings','reviews')->find($id);
        return response()->json(compact('room'), 200);
    }

    public function search(Request $request)
    {

        if($request->has('checkin') && $request->has('checkout') && $request->has('guests')){
            $from = date('Y-m-d', strtotime($request->checkin));
            $to = date('Y-m-d', strtotime($request->to));
            $guests = $request->guests;

            $rooms = Room::where('capacity', '>=', $guests)
            ->with('bookings')
            ->whereHas('bookings', function ($q) use ($from, $to) {
                $q->whereDate('check_in', '>', $to)->whereDate('check_out', '<', $from);
            })
            ->orWhereDoesntHave('bookings')
            ->paginate(8);

            return response()->json(compact('rooms'), 200);
        }
        $rooms = Room::orderByDesc('created_at')->paginate(8);
        return response()->json(compact('rooms'), 200);
    }



}
