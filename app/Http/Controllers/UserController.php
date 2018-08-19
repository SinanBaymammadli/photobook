<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Image;
use ZipArchive;

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
        $user = User::with('photos')->findOrFail($id);
        $photoUrls = $user->photos;

        // create a list of files that should be added to the archive.
        $files = glob(storage_path("app/images/*.jpg"));

        // define the name of the archive and create a new ZipArchive instance.
        $archiveFile = storage_path("app/downloads/files.zip");
        $archive = new ZipArchive();

        // check if the archive could be created.
        if ($archive->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            // loop trough all the files and add them to the archive.
            foreach ($photoUrls as $photoUrl) {
                // download photo from url
                $downloadedPhoto = Image::make($photoUrl);
                // $ch = curl_init($photoUrl);
                // curl_setopt($ch, CURLOPT_HEADER, false);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                // $downloadedPhoto = curl_exec($ch);
                // curl_close($ch);

                if ($archive->addFile($downloadedPhoto, basename($downloadedPhoto))) {
                    // do something here if addFile succeeded, otherwise this statement is unnecessary and can be ignored.
                    continue;
                } else {
                    throw new Exception("file `{$downloadedPhoto}` could not be added to the zip file: " . $archive->getStatusString());
                }
            }

            // close the archive.
            if ($archive->close()) {
                // archive is now downloadable ...
                return response()->download($archiveFile, basename($archiveFile))->deleteFileAfterSend(true);
            } else {
                throw new Exception("could not close zip file: " . $archive->getStatusString());
            }
        } else {
            throw new Exception("zip file could not be created: " . $archive->getStatusString());
        }
    }
}
