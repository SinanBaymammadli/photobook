<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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
        $user = User::with('photos')->findOrFail($id);

        return view("admin.user.show", ["user" => $user]);
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

    public function downloadAllPhotosAsZip($id)
    {
        // get user photo urls
        $user = User::with('photos')->findOrFail($id);
        $photos = $user->photos;

        // create a list of files that should be added to the archive.
        $files = glob(storage_path("app/public/photos/" . $user->id . "/*/*"));

        $zipper = new Zipper;

        $archiveFile = "downloads/photos.zip";

        Zipper::make($archiveFile)->add($files)->close();

        return response()->download($archiveFile)->deleteFileAfterSend(true);
    }
}
