<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
        if (!auth()->user()->can('read-categories')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $categories = Category::all();

        return view("admin.category.index", ["categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('create-categories')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        return view("admin.category.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create-categories')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        // validate request
        $request->validate([
            'img' => ['required', 'image'],
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')],
        ]);

        // upload image
        $requestImage = $request->file('img');
        $filesystem = "public";
        $image = $requestImage->store($filesystem);
        $img_path = preg_replace('/^public\//', 'storage/', $image);

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
        if (!auth()->user()->can('read-categories')) {
            return redirect()->route('home')
                ->withErrors([
                    'permission' => trans('permission.failed'),
                ]);
        }

        $category = Category::findOrFail($id);

        return view("admin.category.show", ["category" => $category]);
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
