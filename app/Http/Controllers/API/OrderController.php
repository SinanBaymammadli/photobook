<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $user = auth()->user();

        if (!$user->can('create-orders')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        // validate request
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.count' => ['required', 'number', 'min:1'],
            'items.*.product_type_id' => ['required', 'number', 'min:1', 'exists:product_types'],
            'items.*.photos' => ['required', 'array'],
            'items.*.photos.*' => ['required', 'image'],
        ]);

        // save order
        $order = new Order;
        $order->user_id = $user->id;
        $order->status_id = 1; // default status is "active"
        $order->save();

        foreach ($request->items as $item) {

            // save orderItem
            $order_item = new OrderItem;
            $order_item->order_id = $order->id;
            $order_item->count = $item->count;
            $order_item->product_type_id = $item->product_type_id;
            $order_item->save();

            // save photos
            foreach ($item->photos as $photo) {
                // upload photo
                try {
                    $filesystem = "public";
                    $image = $photo->store($filesystem);
                    $img_path = preg_replace('/^public\//', '', $image);
                    //save photo
                    $order_photo = new OrderPhoto;
                    $order_photo->order_item_id = $order_item->id;
                    $order_photo->url = $img_path;
                    $order_photo->save();

                    $success = true;
                    $message = "Order successfully added.";
                } catch (Exception $e) {
                    $success = false;
                    $message = $e->getMessage();
                }
            }
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
