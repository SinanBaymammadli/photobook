<?php

namespace App\Http\Controllers\API;

use App\Events\PhotosUploaded;
use App\Http\Controllers\Controller;
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

        try {
            $filesystem = "public";
            $realPath = Storage::disk($filesystem)->getDriver()->getAdapter()->getPathPrefix();
            $user_id = auth()->user()->id;
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
                $photo->save();
            }

            event(new PhotosUploaded(auth()->user()));
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
