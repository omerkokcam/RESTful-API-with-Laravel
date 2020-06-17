<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends ApiController // DİKKAT ET Controller değil
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        //return response(Category::paginate(10));
       // return Category::paginate(10);
        return $this->apiResponse(ResultType::Success,Category::all(), 'categories fetched',200  );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request ->name ;
        $category = new Category();
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->save();
//        return response()->json([
//            "data" => $category,
//            "message" => "Category created."
//        ],201);
        return $this->apiResponse(ResultType::Success,$category,'category is created',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
       return $this->apiResponse(ResultType::Success,$category,'category fetched', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $category->update($input);
        return $this->apiResponse(ResultType::Success,$category,"Category is updated.",200) ;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
            $category->delete();
            return $this->apiResponse(ResultType::Success,$category,"Category is deleted.",200) ;
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
