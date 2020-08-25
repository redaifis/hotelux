<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Room;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardCounts(){
        $customers = User::where('role', 'customer')->count();
        $bookings = Booking::count();
        $rooms = Room::count();

        // Revenue of the last 30 days
        $revenue = Invoice::whereBetween('created_at', [Carbon::today()->startOfMonth(30), Carbon::today()->endOfMonth()])->sum('total');

        return response()->json(compact(['customers', 'bookings', 'rooms', 'revenue']), 200);
    }
}
