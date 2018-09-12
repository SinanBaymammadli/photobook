<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductPhoto;
use App\ProductType;
use Exception;
use Illuminate\Http\Request;
use Storage;

class ProductController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('read-products')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $products = Product::all();

        return view("admin.product.index", ["products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('create-products')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $categories = Category::all();

        return view("admin.product.create", ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create-products')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        // validate request
        $request->validate([
            // product validation
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'details' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'min:1', 'exists:categories,id'],
            'photos' => ['required', "array", "min:1"],
            'photos.*' => ['required', "image"],

            // product type items
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'array'],
            'detail.*' => ['required', 'string'],
            'photo' => ['required', "array"],
            'photo.*' => ['required', "image"],
            'price' => ['required', 'array'],
            'price.*' => ['required', 'integer', 'min:1'],
            'photo_count' => ['required', 'array'],
            'photo_count.*' => ['required', 'integer', 'min:1'],
        ]);

        // create new product and save
        $product = new Product;
        $product->name = $request->product_name;
        $product->description = $request->description;
        $product->details = $request->details;
        $product->category_id = $request->category_id;
        $product->save();

        // upload product photos
        try {
            $filesystem = "public";

            foreach ($request->photos as $product_request_photo) {
                $product_request_photo_file = $product_request_photo->store($filesystem);
                $product_photo_path = preg_replace('/^public\//', 'storage/', $product_request_photo_file);

                // save new ProductPhoto to db
                $product_photo = new ProductPhoto;
                $product_photo->url = $product_photo_path;
                $product_photo->product_id = $product->id;
                $product_photo->save();
            }

            // create new product_types and save
            for ($i = 0; $i < count($request->name); $i++) {
                $product_type = new ProductType;
                $product_type->product_id = $product->id;
                $product_type->name = $request->name[$i];
                $product_type->detail = $request->detail[$i];
                $product_type->price = $request->price[$i];
                $product_type->photo_count = $request->photo_count[$i];

                // upload product_type photo
                $product_type_photo = $request->photo[$i]->store($filesystem);
                $product_type_photo_url = preg_replace('/^public\//', 'storage/', $product_type_photo);

                // save url of photo
                $product_type->img_url = $product_type_photo_url;

                $product_type->save();
            }
        } catch (Exception $e) {
            return $e;
        }

        return redirect()->route('product.show', ['id' => $product->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('read-products')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $product = Product::findOrFail($id);

        return view("admin.product.show", ["product" => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
