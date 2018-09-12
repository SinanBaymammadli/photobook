<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

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
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'min:0', 'exists:categories'],
        ]);

        // upload image
        $requestImage = $request->file('img');
        $filesystem = "public";
        $image = $requestImage->store($filesystem);
        $img_path = preg_replace('/^public\//', '', $image);

        // save category
        $category = new Category;
        $category->name = $request->name;
        $category->img_url = $img_path;
        $category->save();

        return redirect()->route('category.show', ['id' => $category->id]);
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
