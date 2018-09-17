<?php

namespace App\Http\Controllers\API;

use App\AlbumOrder;
use App\AlbumOrderPhoto;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;
use Storage;

class AlbumOrderController extends Controller
{
    protected $MAX_UPLOADABLE_PHOTO_COUNT = 100;
    protected $MIN_UPLOADABLE_PHOTO_COUNT = 2;

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
        $user = auth()->user();

        $orders = AlbumOrder::where('user_id', $user->id)
            ->with("status")
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "success" => true,
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
                    'success' => false,
                    'message' => 'Only one order in a month',
                ]);
            }
        }

        // create new order
        $new_order = new AlbumOrder;
        $new_order->user_id = $user->id;
        $new_order->status_id = 1;
        $new_order->save();

        try {
            $filesystem = "public";
            $realPath = Storage::disk($filesystem)->getDriver()->getAdapter()->getPathPrefix();
            $allowedImageMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/bmp',
                'image/svg+xml',
            ];
            foreach ($request->file("photos") as $request_file) {
                $file = $request_file->store("albums/" . $user->id . "/" . Carbon::now()->toDateString(), $filesystem);
                if (in_array($request_file->getMimeType(), $allowedImageMimeTypes)) {
                    $image = Image::make($realPath . $file);
                    $image->orientate()->save($realPath . $file);
                }
                $success = true;
                $message = "Successfully uploaded image.";
                $path = preg_replace('/^public\//', 'storage/', $file);
                // save new Photo to db
                $photo = new AlbumOrderPhoto;
                $photo->url = $path;
                $photo->album_order_id = $new_order->id;
                $photo->save();
            }
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
            $path = '';
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
