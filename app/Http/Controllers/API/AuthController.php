<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @resource Authentication
 */

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @header Token
     *
     * @response {
     * access_token: "asdasd"
     * }
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => trans('auth.failed'),
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'street' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'zip' => 'required|string|max:255',
            'stripeToken' => 'required|string|max:255',
            //'subscribe' => 'boolean',
        ]);

        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'street' => $request['street'],
                'country_id' => $request['country_id'],
                'city_id' => $request['city_id'],
                'zip' => $request['zip'],
            ]);

            event(new Registered($user));

            // $customer = $user->createAsStripeCustomer();
            // $user->updateCard($request['stripeToken']);
            // $user->updateCardFromStripe();

            // if ($request["subscribe"]) {
            //     $user->newSubscription('main', 'album')->create($request['stripeToken']);
            // } else {
            // Create a Customer:
            $customer = \Stripe\Customer::create([
                'source' => $request["stripeToken"],
                'email' => $request["email"],
            ]);

            $user->stripe_id = $customer->id;
            // $user->card_brand = $customer->sources->data[0]->brand;
            // $user->card_last_four = $customer->sources->data[0]->last4;
            // $user->updateCardFromStripe();
            $user->save();
            //}

            //return $customer;

            return $this->login($request);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json(
            array_merge(
                [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ],
                auth()->user()->toArray()
            )
        );
    }
}
