<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class  ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // return Product::all();
      //return response()->json(Product::all(),200);

        $list = Product::query()->with('categories');
        if($request->has("q")){
            $list->where("name","like","%".$request->query("q").'%');
        }
        if($request->has("sortBy")){
            $list->orderBy($request->query("sortBy"),$request->query('sort','ASC'));
        }


      return response($list->paginate(10),200);
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
        $product = new Product();
        $product->name = $input['name'];
        $product->slug = Str::slug($input['name']);
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product -> save();
        return response()->json([
            "data" => $product,
            "message" => "Product created."
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Product = Product::find($id);
        if($Product)
            return response($Product,200);
        else
            return response(["message" => "Product not found"],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        if($product) {
            $product->update($input);
            return response(["message" => "Product is updated."],200) ;;
        }
        else
            return response(["message" => "Product not found"],404) ;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product){
            $product->delete();
            return response(["message" => "Product is deleted."],200);
        }
        else{
            return response(["message" => "Product is not found"],404) ;
        }
    }
    public function custom1()
    {
        //return Product::select('id','name')->orderBy('created_at','desc')->take(10)->get();
        return Product::selectRaw('id as product_id, name as product_name')->orderBy('created_at','desc')->take(100)->get();

    }
    public function custom2()
    {
        $products = Product::orderBy('created_at','desc')->take(100)->get();
        $mapped = $products -> map(function($product){
            return [
                '_id' => $product['id'],
                'product_name' => $product['name'],
                'product_price' => $product['price'],
            ];
        });
        return $mapped->all();
        //return Product::select('id','name')->orderBy('created_at','desc')->take(10)->get();
       // return Product::selectRaw('id as product_id, name as product_name')->orderBy('created_at','desc')->take(100)->get();

    }
    public function custom3(){
        $products = Product::paginate(10);
        return ProductResource::collection($products);

    }
    public function listWithCategories(){
        $products = Product::with('categories')->paginate(10);
        return ProductWithCategoriesResource::collection($products);


    }
}
