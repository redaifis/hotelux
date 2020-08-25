<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::where('role', 'customer')->withCount('bookings')->orderByDesc('created_at')->paginate(8);
        return response()->json(compact('customers'),200);
    }

    public function deletedCustomers()
    {
        $deletedCustomers = User::onlyTrashed()->where('role', 'customer')->withCount('bookings')->orderByDesc('created_at')->paginate(8);
        return response()->json(compact('deletedCustomers'),200);
    }

    public function totalCustomers()
    {

        $days = [Carbon::today()->subDays(6)->format('M d') , Carbon::today()->subDays(5)->format('M d') , Carbon::today()->subDays(4)->format('M d') ,Carbon::today()->subDays(3)->format('M d') , Carbon::today()->subDays(2)->format('M d') , Carbon::today()->subDays(1)->format('M d') , Carbon::today()->format('M d')];

        $customers = User::whereDate('created_at', '>=', Carbon::today()->subDays(6))->orderBy('created_at')->get()->groupBy(function ($item) {
            return $item->created_at->format('M d');
        })->where('role', 'customer')->toArray();

        // dd($days);

        foreach($days as $day){
            if(!Arr::exists($customers, $day)){
                $customers = Arr::add($customers, $day, []);
            }
        }


        return response()->json(compact('customers'), 200);
    }

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
        $customer = User::findOrFail($id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->country = $request->country;
        $customer->city = $request->city;
        $customer->postal_code = $request->postal_code;
        $customer->state = $request->state;
        $customer->save();
        return response()->json(['customer' => $customer, 'message' => 'Profile has been successfuly updated!'],200);
    }

    public function restore($id){
        $customer = User::onlyTrashed()->where('role', 'customer')->where('id', $id)->first()->restore();
        return response()->json(['message' => 'Customer has been restored!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = User::where('id',$id)->where('role', 'customer')->first();
        $customer->delete();
        return response()->json(['message' => 'customer has been successfuly deleted!']);
    }

    /**
     * Remove the specified resource permanently from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permanentDestroy($id)
    {
        $customer = User::onlyTrashed()->where('role', 'customer')->where('id', $id)->first();
        $customer->forceDelete();
        return response()->json(['message' => 'customer has been successfuly deleted!']);
    }
}
