<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getData()
    {
        $categories = Category::where('parent_id', null)->with('children')->get();
        return $categories;
    }

    public function saveTree(Request $request)
    {
        $categories = $request['categories'];
        Category::truncate();

        $this->saveCategories($categories);
    }

    public function saveCategories($categories, $id = null)
    {
        foreach ($categories as $category) {
            $new_cat = new Category();
            $new_cat->name = $category['name'];
            $new_cat->parent_id = $id;
            $new_cat->save();

            if (isset($category['children']) && count($category['children']) > 0) {
                $this->saveCategories($category['children'], $new_cat->id);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);
        $category = new Category();

        $category->name = $request['category_name'];
        $category->parent_id = $request['category_parent'];
        $category->save();

        $categories = $this->getData();

        return $categories;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, $id = null)
    {
        Category::where('id', $request['id'])->update([
            'name' => $request['name']
        ]);
        $categories = $this->getData();

        return $categories;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
