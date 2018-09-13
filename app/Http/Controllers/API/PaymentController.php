<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use \Stripe\Charge;
use \Stripe\Customer;

class PaymentController extends Controller
{
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
        $token = $request->token;

        try {
            // Create a Customer:
            $customer = Customer::create([
                'source' => $token,
                'email' => 'paying.user@example.com',
            ]);

            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => 999,
                'currency' => 'usd',
                'description' => 'Example charge',
            ]);

            $success = true;
            $message = "Successful payment";
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('success', 'message'));
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
