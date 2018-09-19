<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
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
        ]);

        try {
            $token = $request->token;
            $user = auth()->user();
            $user->newSubscription('main', 'album')->create($token);
            // "album" is the specific Stripe plan the user is subscribing to. This value should correspond to the plan's identifier in Stripe.
            return response()->json([
                "message" => "Successfully added to monthly subscription.",
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
    public function destroy()
    {
        try {
            $user = auth()->user();
            $user->subscription('main')->cancel();

            return response()->json([
                "message" => "Subscription canceled.",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 422);
        }
    }
}
