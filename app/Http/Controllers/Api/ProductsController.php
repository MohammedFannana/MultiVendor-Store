<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // filter is define Product Model use To filter Data 
        // query() mean the parameter is get from url
        //in other website not use the 
        // use with to  return the all information of store and category and tags use relationship
        // base store_id & category_id & tag_id 

        //category:id,name means from relation category return only id and name  id is basic 

        //with use in relation in paginate
        // return Product::filter($request->query())
        //     ->with('category:id,name', 'store:id,name', 'tags:id,name')
        //     ->paginate();

        // if use ApiResource
        $products =  Product::filter($request->query())
            ->with('category:id,name', 'store:id,name', 'tags:id,name')
            ->paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status'   => 'in:active,draft,archvied',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price'
        ]);

        // in api use return to return data

        //id after procces is success need to redirect in other page how in api


        $product = Product::create($request->all());
        return Response::json($product, 201, [
            'Location' => route('products.show', $product->id)
            //this location is not work but this example
        ]);

        //201 mean the process is success
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     return Product::findOrFail($id)->with('category:id,name', 'store:id,name', 'tags:id,name');
    // }

    public function show(Product $product)
    {
        // use Api resource
        return new ProductResource($product);

        // load use as with   but load use with object model and with us with query builder
        // return $product
        //     ->load('category:id,name', 'store:id,name', 'tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //in the update not use required self beacuse the column maybe not change data
        // beacuse this use sometimes before required in updata process  
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status'   => 'in:active,draft,archvied',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price'
        ]);

        // in api use return to return data

        $product->update($request->all());

        return Response::json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        // return Response::json(null, 204);
        return Response::json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
