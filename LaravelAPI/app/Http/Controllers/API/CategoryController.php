<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // $product = Product::create($input);
        $category = new Category();
        $category->name = $input['name'];
        $category->slug = Str::slug($input['name']);
        $category -> save();
        return response()->json([
            "data" => $category,
            "message" => "Category created."
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category)
            return response($category,200);
        else
            return response(["message" => "Category not found"],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        if($category) {
            $category->update($input);
            return response(["message" => "Category is updated."],200) ;;
        }
        else
            return response(["message" => "Category not found"],404) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category){
            $category->delete();
            return response(["message" => "Category is deleted."],200);
        }
        else{
            return response(["message" => "Category is not found"],404) ;
        }
    }
    public function custom1()
    {
        return Category::pluck('name','id');

    }
    public function report1(){
        return DB::table('product_category')
            ->selectRaw('category_id,COUNT(*) as total')
            ->join('categories', 'categories.id','=','product_category.category_id' )
            ->join('products', 'products.id','=','product_category.product_id' )
            ->groupBy('category_id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }
}
