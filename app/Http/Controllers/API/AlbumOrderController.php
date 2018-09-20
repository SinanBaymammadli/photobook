<?php

namespace App\Http\Controllers\API;

use App\AlbumOrder;
use App\AlbumOrderPhoto;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Storage;

class AlbumOrderController extends Controller
{
    protected $MAX_UPLOADABLE_PHOTO_COUNT = 100;
    protected $MIN_UPLOADABLE_PHOTO_COUNT = 1;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()) {
            return response()->json([
                "message" => "Not authenticated",
            ], 422);
        }

        $user = auth()->user();

        $orders = AlbumOrder::where('user_id', $user->id)
            ->with("status")
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "orders" => $orders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $request->validate([
            "photos" => "required|array|max:" . $this->MAX_UPLOADABLE_PHOTO_COUNT . "|min:" . $this->MIN_UPLOADABLE_PHOTO_COUNT,
            "photos.*" => "required|image",
        ]);

        // find last order date
        $user = auth()->user();
        $last_order = AlbumOrder::where('user_id', $user->id)->latest()->first();

        // if in same month return false
        if ($last_order) {
            $last_order_date = $last_order->created_at;
            $now = Carbon::now();

            if ($last_order_date->isSameMinute($now)) {
                return response()->json([
                    'message' => 'Only one order in a month',
                ], 422);
            }
        }

        // create new order
        $album_order = new AlbumOrder;
        $album_order->user_id = $user->id;
        $album_order->status_id = 1;
        $album_order->save();

        // upload photos
        $filesystem = "public";
        try {
            foreach ($request->photos as $photo) {
                // upload photo
                $stored_photo = $photo->store("albums/" . $user->id . "/" . $album_order->created_at->toDateTimeString(), $filesystem);
                $stored_photo_url = preg_replace('/^public\//', '', $stored_photo);

                // save new Photo to db
                $photo = new AlbumOrderPhoto;
                $photo->url = $stored_photo_url;
                $photo->album_order_id = $album_order->id;
                $photo->save();
            }

            return response()->json([
                'message' => 'Album successfully ordered.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
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
