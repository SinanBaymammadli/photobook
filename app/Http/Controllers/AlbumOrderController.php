<?php

namespace App\Http\Controllers;

use App\AlbumOrder;
use App\AlbumOrderPhoto;
use App\OrderStatus;
use Illuminate\Http\Request;
use Zipper;

class AlbumOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = AlbumOrder::with('user')->with('status')->orderBy('id', 'desc')->get();

        return view("admin.album-order.index", ["orders" => $orders]);
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
        $order = AlbumOrder::with('user')->with('status')->with('photos')->findOrFail($id);

        return view("admin.album-order.show", ["order" => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = AlbumOrder::findOrFail($id);
        $order_statuses = OrderStatus::all();

        return view("admin.album-order.edit", ["order" => $order, "order_statuses" => $order_statuses]);
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
        $order = AlbumOrder::findOrFail($id);
        $order->status_id = $request->status_id;

        $order->save();

        return redirect()->route('album-order.index');
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

    public function downloadFilesAsZip($files)
    {
        $zipper = new Zipper;

        $archiveFile = "downloads/files.zip";

        Zipper::make($archiveFile)->add($files)->close();

        return response()->download($archiveFile)->deleteFileAfterSend(true);
    }

    public function getAlbumOrderPhotos($id)
    {
        // create a list of photos that should be added to the archive.
        $photos = AlbumOrderPhoto::where("album_order_id", $id)->get();
        $photosArray = [];

        foreach ($photos as $photo) {
            array_push($photosArray, storage_path("app/public/" . $photo->url));
        }

        return $photosArray;
    }

    public function download($id)
    {
        $photos = $this->getAlbumOrderPhotos($id);
        return $this->downloadFilesAsZip($photos);
    }
}
