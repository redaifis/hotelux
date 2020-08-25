<?php

namespace App\Http\Controllers\Api\v1;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->bookingDetails['datesRange']);
        $user = Auth::user();
        $paymentMethod = $request->paymentMethod;
        $total = $request->invoiceDetails['total'] * 100;
        try {
            $payment = $user->charge($total, $paymentMethod['id']);

        } catch (Exception $e) {
            dd($e);
        }

        $bookingId = $this->storeBooking($request->bookingDetails);

        $invoice = $this->storeInvoice($bookingId, $request->invoiceDetails);

        return response()->json(['message' => 'Booking has been successfully created!', 'invoice' => $invoice], 200);

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

    protected function storeBooking($bookingDetails){
        $booking = new Booking();
        $booking->check_in = date('Y-m-d',strtotime($bookingDetails['datesRange']['start']));
        $booking->check_out = date('Y-m-d', strtotime($bookingDetails['datesRange']['end']));
        $booking->guests = $bookingDetails['guests'];
        $booking->room_id = $bookingDetails['roomId'];
        $booking->user_id = Auth::id();
        $booking->save();
        return $booking->id;
    }

    protected function storeInvoice($bookingId, $invoiceDetails){
        $invoice =  new Invoice();
        $invoice->booking_id = $bookingId;
        $invoice->total = $invoiceDetails['total'];
        $invoice->payment_type = "Credit Card";
        $invoice->status = 1;
        $invoice->save();
        return $invoice;
    }
}
