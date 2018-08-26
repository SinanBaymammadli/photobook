<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
        if (!auth()->user()->can('read-users')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

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
        if (!auth()->user()->can('create-users')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $roles = Role::all();
        return view("admin.user.create", ["roles" => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create-users')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        // validate request
        $request->validate([
            'avatar' => ['image', 'nullable'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // find user
        $user = new User;

        // update values
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        //if has avatar
        if ($request->hasFile('avatar')) {
            try {
                // create new image
                $requestImage = $request->file('avatar');
                // save to storage
                $filesystem = "public";
                $image = $requestImage->store($filesystem);
                $path = preg_replace('/^public\//', '', $image);
                // update user avatar url
                $user->avatar = $path;
            } catch (Exception $e) {
                return $e;
            }
        }

        $user->save();

        // attach role after saving user
        $user->attachRole($request->role);

        return redirect()->route('user.show', ['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('read-users')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

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
        if (!auth()->user()->can('update-users')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $user = User::findOrFail($id);
        $roles = Role::all();

        return view("admin.user.edit", ["user" => $user, "roles" => $roles]);
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
        if (!auth()->user()->can('update-users')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        // validate request
        $request->validate([
            'avatar' => ['image', 'nullable'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'password' => ['string', 'min:6', 'confirmed', 'nullable'],
        ]);

        // find user
        $user = User::findOrFail($id);

        // update values
        $user->name = $request->name;
        $user->email = $request->email;

        // detach previous role attach new one
        $user->detachRoles($user->roles);
        $user->attachRole($request->role);

        //if has avatar
        if ($request->hasFile('avatar')) {
            try {
                // delete old image
                // create new image
                $requestImage = $request->file('avatar');
                // save to storage
                $filesystem = "public";
                $image = $requestImage->store($filesystem);
                $path = preg_replace('/^public\//', '', $image);
                // update user avatar url
                $user->avatar = $path;
            } catch (Exception $e) {
                return $e;
            }
        }

        // if has new password
        if ($request->password) {
            //dd($request->password);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.show', ['id' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete-users')) {
            return redirect()->route('user.index')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }

    public function downloadFilesAsZip($files)
    {
        $zipper = new Zipper;

        $archiveFile = "downloads/files.zip";

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
