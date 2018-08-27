<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Order;
use App\Photo;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Image;
use Storage;

class PhotoController extends Controller
{
    protected $MAX_UPLOADABLE_PHOTO_COUNT = 100;
    protected $MIN_UPLOADABLE_PHOTO_COUNT = 2;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            "file" => "required|array|max:" . $this->MAX_UPLOADABLE_PHOTO_COUNT . "|min:" . $this->MIN_UPLOADABLE_PHOTO_COUNT,
            "file.*" => "required|image",
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
        $this->validator($request->all())->validate();

        // find last order date
        $user_id = auth()->user()->id;
        $last_order = Order::where('user_id', $user_id)->latest()->first();

        // if in same month return false
        if ($last_order) {
            $last_order_date = $last_order->created_at;
            $now = Carbon::now();

            if ($last_order_date->isSameMonth($now)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only one order in a month',
                ]);
            }
        }

        // create new order
        $new_order = new Order;
        $new_order->user_id = $user_id;
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
            foreach ($request->file as $request_file) {
                $file = $request_file->store("photos/" . $user_id . "/" . Carbon::now()->toDateString(), $filesystem);
                if (in_array($request_file->getMimeType(), $allowedImageMimeTypes)) {
                    $image = Image::make($realPath . $file);
                    $image->orientate()->save($realPath . $file);
                }
                $success = true;
                $message = "Successfully uploaded image.";
                $path = preg_replace('/^public\//', '', $file);
                // save new Photo to db
                $photo = new Photo;
                $photo->url = $path;
                $photo->user_id = $user_id;
                $photo->order_id = $new_order->id;
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
