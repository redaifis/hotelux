<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Room;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboardCounts(){
        $customers = User::where('role', 'customer')->count();
        $bookings = Booking::count();
        $rooms = Room::count();

        // Revenue of the last 30 days
        $revenue = Invoice::whereBetween('created_at', [Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth()])->sum('total');
        // dd(Carbon::today()->startOfMonth());
        return response()->json(compact(['customers', 'bookings', 'rooms', 'revenue']), 200);
    }


    public function updateProfile(Request $request, $id){
        $profile = User::findOrFail($id);
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->country = $request->country;
        $profile->city = $request->city;
        $profile->postal_code = $request->postal_code;
        $profile->state = $request->state;
        $profile->save();
        return response()->json(['profile' => $profile, 'message' => 'Profile has been successfuly updated!'],200);
    }

    public function updatePassword(Request $request, $id){
        $profile = User::findOrFail($id);
        $profile->password = Hash::make($request->password);
        $profile->save();
        return response()->json(['message' => 'Password has been successfuly updated!'],200);
    }
}
