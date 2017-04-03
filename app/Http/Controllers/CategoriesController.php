<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoriesController extends Controller
{
    /**
     * @var Category
     */
    private $category;

    /**
     * CategoriesController constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->with('children')->whereNull('parent_id')->get();
        $categories = collect($categories)->map(function($category){
           $category = $category->translate(LaravelLocalization::getCurrentLocale());
            return [
                'id' => $category->category_id,
                'name' => $category->name,
                'icon' => "/img/icons/{$category->key}.png",
                'slug' => $category->slug,
                'children' => $this->get_sub_categories($category->category_id)
            ];
        });


        return response()->json($categories);
    }

    private function get_sub_categories($parent_id)
    {
        $categories = $this->category->where('parent_id', $parent_id)->get();
        return $categories->map(function($category){
            $category = $category->translate(LaravelLocalization::getCurrentLocale());
            return [
                'id' => $category->category_id,
                'name' => $category->name,
                'slug' => $category->slug
            ];
        });
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
        $categories = $this->category->with('children')->where('id', $id)->first()->children;
        return response()->json($categories);
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
