<?php

namespace App\Http\Controllers\API;

use App\Album;
use App\AlbumOrder;
use App\AlbumOrderPhoto;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
            "photos" => "required|array|min:1",
            "photos.*" => "required|image",
            'count' => ['required', 'array'],
            'count.*' => ['required', 'integer', 'min:1'],
        ]);

        $user = auth()->user();

        // find last order date
        $last_order = AlbumOrder::where('user_id', $user->id)->latest()->first();

        // if in same month return false
        if ($last_order) {
            $last_order_date = $last_order->created_at;
            $now = Carbon::now();

            if ($last_order_date->isSameMinute($now)) { // TODO: change to isSameMonth
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
        try {
            for ($i = 0; $i < count($request->photos); $i++) {
                $photo_path = Storage::putFile('albums/' . $user->id . '/' . $album_order->id, new File($request->photos[i]));

                // save new Photo to db
                $photo = new AlbumOrderPhoto;
                $photo->url = $photo_path;
                $photo->count = $request->count[i];
                $photo->album_order_id = $album_order->id;
                $photo->save();
            }

            if (!$user->subscribed('main')) {
                $user->newSubscription('prod_EwgNCzK1rTKFRP', 'plan_EwgPp6KtN2zfcW')->create();
            }

            return response()->json([
                'message' => 'Album created',
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

    public function addPhotos(Request $request, $album_order_id)
    {
        // validate
        $request->validate([
            "photos" => "required|array|min:1",
            "photos.*" => "required|image",
            'count' => ['required', 'array'],
            'count.*' => ['required', 'integer', 'min:1'],
        ]);

        // upload photos
        try {
            for ($i = 0; $i < count($request->photos); $i++) {
                $photo_path = Storage::putFile('albums/' . auth()->user()->id . '/' . $album_order_id, new File($request->photos[$i]));

                // save new Photo to db
                $photo = new AlbumOrderPhoto;
                $photo->url = $photo_path;
                $photo->count = $request->count[$i];
                $photo->album_order_id = $album_order_id;
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
