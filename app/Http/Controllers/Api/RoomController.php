<?php

namespace App\Http\Controllers\Api;

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
    public function index()
    {
        $rooms = Room::orderByDesc('created_at')->get();

        return response()->json(compact('rooms'), 200);
    }

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
        $room = Room::find($id);
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

        // delete old images
        foreach ($room->images as $image) {
            $oldImagePath = "images/rooms/" . $image;
            File::delete(public_path($oldImagePath));
        }

        $room->title = Str::title($request->title);
        $room->description = $request->description;
        $room->price = $request->price;

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
        $room->hotel_id = 1;

        $room->save();

        return response()->json(['message' => 'Room has been successfuly updated!', 'room' => $room], 200);
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

        // delete old images
        foreach ($room->images as $image) {
            $oldImagePath = "images/rooms/" . $image;
            File::delete(public_path($oldImagePath));
        }

        $room->delete();

        return response()->json(['message' => 'Room has been deleted successfuly!']);
    }
}
