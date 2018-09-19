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
        $request->validate([
            "token" => ["required", "string"],
            "total" => ["required", "integer"],
        ]);

        $user = auth()->user();

        try {
            //Create a Customer:
            $customer = Customer::create([
                'source' => $request->token,
                'email' => $user->email,
            ]);

            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $request->total,
                'currency' => 'dkk',
                'description' => 'Example charge',
            ]);

            return response()->json([
                "message" => "Successful payment",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 422);
        }
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
