<?php

namespace App\Http\Controllers\API;

use App\Album;
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

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    protected $filesystem = "public";

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
            ->with("photos")
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function uploadPhoto($photo)
    {
        $stored_photo = $photo->store('albums', $this->filesystem);
        $stored_photo_url = preg_replace('/^public\//', '', $stored_photo);
        return $stored_photo_url;
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
        // $request->validate([
        //     "photos" => "required|array|min:1",
        //     "photos.*" => "required|image",
        // ]);

        $user = auth()->user();

        if (!$user->subscribed('main')) {
            $user->newSubscription('main', 'album')->create();
        }

        // find last order date
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

        return response()->json([
            'message' => 'Photos added.',
        ]);

        // upload photos
        $filesystem = "public";
        try {
            // foreach ($request->photos as $photo) {
            //     // upload photo
            //     $stored_photo_url = $this->uploadPhoto($photo);

            //     // save new Photo to db
            //     $photo = new AlbumOrderPhoto;
            //     $photo->url = $stored_photo_url;
            //     $photo->album_order_id = $album_order->id;
            //     $photo->save();
            // }

            return response()->json([
                'message' => 'Photos added.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
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
        $album_order = AlbumOrder::findOrFail($id);

        $album_order->ordered = 1;

        $album_order->save();

        return response()->json([
            "message" => "Successfully ordered.",
        ]);
    }

    public function addPhotos(Request $request, $id)
    {
        return response()->json([
            'message' => 'Photos added.',
        ]);
        // validate
        // $request->validate([
        //     "photos" => "required|array|min:1",
        //     "photos.*" => "required|image",
        // ]);

        // upload photos
        try {
            foreach ($request->photos as $photo) {
                // upload photo
                $stored_photo_url = $this->uploadPhoto($photo);

                // save new Photo to db
                $photo = new AlbumOrderPhoto;
                $photo->url = $stored_photo_url;
                $photo->album_order_id = $id;
                $photo->save();
            }

            return response()->json([
                'message' => 'Photos added.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
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

    public function settings()
    {
        $album = Album::findOrFail(1);

        return response()->json($album);
    }
}
