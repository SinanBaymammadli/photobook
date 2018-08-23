<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Zipper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('photos')->get();

        return view("admin.user.index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $photoDates = Photo::select("created_at")
            ->where("user_id", $id)
            ->get()
            ->unique(function ($photoDate) {
                return Carbon::parse($photoDate->created_at)->format('d'); // grouping by days
                // return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                // return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        //dd($photoDates);

        return view("admin.user.show", ["user" => $user, "photoDates" => $photoDates]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view("admin.user.edit", ["user" => $user]);
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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }

    public function downloadFilesAsZip($files)
    {
        $zipper = new Zipper;

        $archiveFile = "downloads/photos.zip";

        Zipper::make($archiveFile)->add($files)->close();

        return response()->download($archiveFile)->deleteFileAfterSend(true);
    }

    public function downloadAllPhotosAsZip($userId)
    {
        // create a list of files that should be added to the archive.
        $photos = Photo::where("user_id", $userId)
            ->get();
        $photosArray = [];

        foreach ($photos as $photo) {
            array_push($photosArray, storage_path("app/public/" . $photo->url));
        }

        return $this->downloadFilesAsZip($photosArray);
    }

    public function downloadPhotosByDateAsZip($userId, $date)
    {
        $photos = Photo::where("user_id", $userId)
            ->whereDate("created_at", $date)
            ->get();
        $photosArray = [];

        foreach ($photos as $photo) {
            array_push($photosArray, storage_path("app/public/" . $photo->url));
        }

        return $this->downloadFilesAsZip($photosArray);
    }

    public function showPhotosByDate($userId, $date)
    {
        $user = User::findOrFail($userId);
        $photos = Photo::where("user_id", $userId)
            ->whereDate("created_at", $date)
            ->get();

        return view("admin.photo.bydate", ["user" => $user, "photos" => $photos, "date" => $date]);
    }
}
