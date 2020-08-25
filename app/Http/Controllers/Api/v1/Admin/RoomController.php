<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RoomController extends Controller
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
        $rooms = Room::orderByDesc('created_at')->paginate(8);
        return response()->json(compact(['rooms']), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletedRooms()
    {
        $deletedRooms = Room::onlyTrashed()->orderByDesc('created_at')->paginate(8);
        return response()->json(compact(['deletedRooms']), 200);
    }



    // public function search(Request $request)
    // {

    //     if($request->has('checkin') && $request->has('checkout') && $request->has('guests')){
    //         $from = date('Y-m-d', strtotime($request->checkin));
    //         $to = date('Y-m-d', strtotime($request->to));
    //         $guests = $request->guests;

    //         $rooms = Room::where('capacity', '>=', $guests)
    //         ->with('bookings')
    //         ->whereHas('bookings', function ($q) use ($from, $to) {
    //             $q->whereDate('check_in', '>', $to)->whereDate('check_out', '<', $from);
    //         })
    //         ->paginate(8);

    //         return response()->json(compact('rooms'), 200);

    //     }
    //     $rooms = Room::orderByDesc('created_at')->paginate(8);
    //     return response()->json(compact('rooms'), 200);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = new Room;

        $room->title = Str::title($request->title);
        $room->slug = Str::slug($request->title);
        $room->description = $request->description;
        $room->price = $request->price;
        $room->capacity = $request->capacity;

        if ($request->hasFile('images')) {
            $imagesArr = [];

            foreach ($request->images as $image) {
                if (!$image->isValid()) {
                    return response()->json(['message' => 'Invalid images!'], 200);
                }
                $extension = $image->extension();
                $imageName = Str::random(10) . "." . $extension;
                $image->move(public_path('/images/rooms'), $imageName);
                array_push($imagesArr, $imageName);
            }

            $room->images = collect($imagesArr);
        }


        $room->hotel_id = 1;

        $room->save();

        return response()->json(['message' => 'Room has been successfuly created!', 'room' => $room], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::with('bookings')->find($id);
        return response()->json(compact('room'), 200);
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
        $room = Room::find($id);

        // if has files, delete old images and insert new ones
        if($request->hasFile('images')){
            foreach ($room->images as $image) {
                $oldImagePath = "images/rooms/" . $image;
                File::delete(public_path($oldImagePath));
            }

            $imagesArr = [];

            foreach ($request->images as $image) {
                if (!$image->isValid()) {
                    return response()->json(['message' => 'Invalid images!'], 200);
                }
                $extension = $image->extension();
                $imageName = Str::random(10) . "." . $extension;
                $image->move(public_path('/images/rooms'), $imageName);
                array_push($imagesArr, $imageName);
            }

            $room->images = collect($imagesArr);
        }

        $room->title = Str::title($request->title);
        $room->slug = Str::slug($request->title);
        $room->description = $request->description;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->hotel_id = 1;

        $room->save();

        return response()->json(['message' => 'Room has been successfuly updated!', 'room' => $room], 200);
    }

    public function restore($id){
        $room = Room::withTrashed()->findOrFail($id)->restore();
        return response()->json(compact('room'),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        // dd($room);
        // delete old images


        $room->delete();

        return response()->json(['message' => 'Room has been deleted successfuly!']);
    }

    public function permanentDestroy($id){

        $room = Room::withTrashed()->findOrFail($id);
        foreach ($room->images as $image) {
            $oldImagePath = "images/rooms/" . $image;
            File::delete(public_path($oldImagePath));
        }
        $room->forceDelete();

        return response()->json(['message' => 'Room has been deleted successfuly!']);

    }
}
